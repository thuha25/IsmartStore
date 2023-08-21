<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    
    function __construct()
    {
        $this->middleware(function ($request,$next) {
            session(['module_active'=>'order']);
            return $next($request);
        });
    }
    function list(Request $request){
        $state = $request->input('state');
        $list_act = [
            'complete' => 'Hoàn thành',
            'move' => 'Đang vận chuyển',
            'processing' => 'Đang xử lý',
            'cancel'=>'Huỷ đơn',
            'delete'=>'Xoá tạm thời'
        ];
        if ($state === 'trash') {
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
            $orders = Order::onlyTrashed()->paginate(10);
        }else if ($state === 'complete') {
            $orders = Order::where('state', 'Hoàn thành')->paginate(10);
        } else if ($state ===  'move') {
            $orders = Order::where('state', 'Đang vận chuyển')->paginate(10);
        } else if ($state ===  'processing') {
            $orders = Order::where('state', 'Đang xử lý')->paginate(10);
        }else if ($state ===  'cancel') {
            $orders = Order::where('state', 'Huỷ đơn')->paginate(10);
        }else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword =  $request->input('keyword');
            }
            $orders = Order::where("customer_name", "LIKE", "%{$keyword}%")->paginate(10);
        }
        $count_order_all = Order::count();
        $count_order_complete = Order::where('state', 'Hoàn thành')->count();
        $count_order_move = Order::where('state', 'Đang vận chuyển')->count();
        $count_order_processing = Order::where('state', 'Đang xử lý')->count();
        $count_order_cancel = Order::where('state', 'Huỷ đơn')->count();
        $count_order_trash = Order::onlyTrashed()->count();
        $count = [$count_order_all, $count_order_complete, $count_order_move,$count_order_processing,$count_order_cancel,$count_order_trash];
        return view('admin.order.list', ['orders' => $orders],compact('count','list_act'));
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Order::destroy($list_check);
                return redirect('admin/order/list')->with('success', 'Bạn đã xoá thành công');
            }
            if ($act == 'complete') {
                $newStates = 'Hoàn thành';
                $ordersToUpdate = Order::whereIn('iddH', $list_check)->where('state', '!=', $newStates);
                $updatedCount = $ordersToUpdate->update(['state' => $newStates]);
                if ($updatedCount > 0) {
                    return redirect('admin/order/list')->with('success', 'Bạn đã đổi trạng thái thành công');
                } else {
                    return redirect('admin/order/list');
                }
            }
            if ($act == 'move') {
                $newStates = 'Đang vận chuyển';
                $ordersToUpdate = Order::whereIn('idDH', $list_check)->where('state', '!=', $newStates);
                $updatedCount = $ordersToUpdate->update(['state' => $newStates]);
                if ($updatedCount > 0) {
                    return redirect('admin/order/list')->with('success', 'Bạn đã đổi trạng thái thành công');
                } else {
                    return redirect('admin/order/list');
                }
            }
            if ($act == 'processing') {
                $newStates = 'Đang xử lý';
                $ordersToUpdate = Order::whereIn('iddH', $list_check)->where('state', '!=', $newStates);
                $updatedCount = $ordersToUpdate->update(['state' => $newStates]);
                if ($updatedCount > 0) {
                    return redirect('admin/order/list')->with('success', 'Bạn đã đổi trạng thái thành công');
                } else {
                    return redirect('admin/order/list');
                }
            }
            if ($act == 'cancel') {
                $newStates = 'Huỷ đơn';
                $ordersToUpdate = Order::whereIn('idDH', $list_check)->where('state', '!=', $newStates);
                $updatedCount = $ordersToUpdate->update(['state' => $newStates]);
                if ($updatedCount > 0) {
                    return redirect('admin/order/list')->with('success', 'Bạn đã đổi trạng thái thành công');
                } else {
                    return redirect('admin/order/list');
                }
            }
            if ($act == 'restore') {
                Order::withTrashed()
                    ->whereIn('idDH', $list_check)
                    ->restore();
                return redirect('admin/order/list')->with('success', 'Bạn đã khôi phục thành công');
            }
            if ($act == 'forceDelete') {
                Order::withTrashed()
                    ->whereIn('idDH', $list_check)
                    ->forceDelete();
                return redirect('admin/order/list')->with('success', 'Bạn đã xoá trang thành công');
            }
        } else {
            return redirect('admin/order/list')->with('success', 'Bạn cần chọn phần tử thực hiện');
        }
    }
    function detail($idDH){
        $orderDetails = OrderDetail::where('idDH', $idDH)->get();
        return view('admin.order.detail', ['orderDetails' => $orderDetails]);
    }
    function update_status($idDH){
        $newStatus = request('status_order');
        $oldStatus = Order::where('idDH', $idDH)->value('state');
        if ($newStatus !== $oldStatus) {
            Order::where('idDH', $idDH)->update([
                'state' => $newStatus
            ]);
            return redirect()->route('admin.order.detail', ['id' => $idDH])->with('success', 'Trạng thái đơn hàng đã được cập nhật');
        } else {
            return redirect()->route('admin.order.detail', ['id' => $idDH])->with('info', 'Trạng thái đơn hàng không thay đổi');
        }
    }
    function delete($idDH) {
        $orders = Order::where('idDH',$idDH);
        $orders->delete();
        return redirect()->route('admin.order.list')->with('success', 'Đơn hàng đã được xoá thành công!'); 
    }
}
