<?php
namespace App\Http\Controllers;
use App\Models\CatProduct;
use App\Models\BrandProduct;
use App\Models\Product;
use App\Models\ColorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
class CartController extends Controller
{
    public function ajaxAdd(Request $request)  {
        $data = $request->all();
        $product_id = $data['product_id'];
        $product = Product::find($product_id);
        $color_id = $data['color_id'];
        $color = ColorProduct::find($color_id);
        Cart::add([
            'id' => $product_id . '_' . $color_id,
            'name' => $product->product_name,
            'qty' => 1,
            'price' => $product->product_price,
            'options' => [
                'color' => $color->color_name,
                'thumbnail' => $product->thumbnail_path,
            ]
        ]);
        echo Cart::count();
    }
    public function update(Request $request)  {
        $data = $request->all();
        Cart::update($data['product_id'], $data['qty']);
        foreach (Cart::content() as $row) {
            $respon['cart'][$row->rowId] = number_format($row->total, 0, '', '.') . 'đ';
        }
        $respon['total'] = Cart::total();
        $respon['count'] = Cart::count();
        return response()->json($respon);
    }
    public function show()
    {
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $cat = Cart::content();
        return view('cart.show', compact('cat_products', 'brandsWithProducts','cat'));
    }
    function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('cart.show');
    }
    function destroy()
    {
        Cart::destroy();
        return redirect()->route('cart.show');
    }
    function checkout(){
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $cat = Cart::content();
        return view('cart.checkout',compact('cat_products','brandsWithProducts','cat'));
    }
    function order(Request $request) {
        $request->validate(
            [
            'customer_name'=>'required',
            'customer_phone'=>'required|regex:/^\d{10,11}$/',
            'customer_email'=>'required|email',
            'province_id'=>'required',
            'ward_id'=>'required',
            'district_id'=>'required',
            'num_house'=>'required',
            ],
            [
                'required'=>':attribute không được để trống',
                'email' => 'Email không hợp lệ',
                'regex' => 'Số điện thoại không hợp lệ.',
            ],
            [
                'customer_name' => 'Họ và tên',
                'customer_phone' => 'Số điện thoại',
                'customer_email'=>'Email',
                'province_id'=>'Tỉnh/thành phố',
                'ward_id'=>'Phường/xã',
                'district_id'=>'Quận/huyện',
                'num_house'=>'Số nhà, tên đường'
            ]

        );
        $idDH = str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);
        $cart = Cart::content();
        $customerAddress = $request->input('num_house') . '- ' .
                       $request->input('ward_id') . '- ' .
                       $request->input('district_id') . '- ' .
                       $request->input('province_id');

        $dataOrder = [
            'idDH'=>$idDH,
            'customer_name' => $request->input('customer_name'),
            'customer_phone' => $request->input('customer_phone'),
            'customer_email' => $request->input('customer_email'),
            'customer_address' => $customerAddress,
            'customer_note' => $request->input('customer_note'), 
            'status' => $request->input('status'), 
            'state' => 'Đang xử lý',
            'created_at'=> now()
        ];
        DB::table('orders')->insertGetId($dataOrder);

        $totalSum = 0;
        foreach ($cart as $item) {
            $totalSum += $item->total;
        }

        $orderDetails  = [];
        foreach ($cart as $item) {
            $orderDetail = [
                'idDH' => $idDH,
                'product_name' => $item->name,
                'product_price' => $item->price,
                'image_product'=>$item->options->thumbnail,
                'color'=>$item->options->color,
                'qty' => $item->qty,
                'total_price' => $item->total,
                'total_sum' => $totalSum,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $orderDetails [] = $orderDetail;
        }
      
        DB::table('order_details')->insert($orderDetails);

        Mail::to($request->input('customer_email'))->send(new OrderPlaced($idDH, $orderDetails));
        Cart::destroy();
        return redirect()->route('detailOrder', ['idDH' => $idDH]);
    }
    function detailOrder($idDH) {
        $cat_products = CatProduct::all();
        $brandsWithProducts = BrandProduct::with('products')->get();
        $cat = Cart::content();
        $order = DB::table('orders')->where('idDH', $idDH)->first();
        $orderDetails = DB::table('order_details')->where('idDH', $idDH)->get();
        return view('cart.detailOrder', compact('cat_products', 'brandsWithProducts', 'cat', 'order', 'orderDetails'));
    }
  
}
