<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }
    function show()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        $successfulOrdersCount = Order::where('state', 'Hoàn thành')->count();
        $moveOrdersCount = Order::where('state', 'Đang vận chuyển')->count();
        $processingOrdersCount = Order::where('state', 'Đang xử lý')->count();
        $cancelOrdersCount = Order::where('state', 'Huỷ đơn')->count();
        $totalRevenue = 0;
        foreach ($orders as $order) {
            foreach ($order->orderdetail as $orderDetail) {
                $totalRevenue += $orderDetail->total_price;
            }
        }
        
        return view('admin.dashboard', [
            'orders' => $orders,
            'successfulOrdersCount' => $successfulOrdersCount,
            'moveOrdersCount' => $moveOrdersCount,
            'processingOrdersCount' => $processingOrdersCount,
            'cancelOrdersCount' => $cancelOrdersCount,
            'totalRevenue' => $totalRevenue
        ]);
    }
}
