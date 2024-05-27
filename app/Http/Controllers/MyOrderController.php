<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function renderMyOrders()
    {
        if (!Auth::check()) {
            return redirect()->back()->with([
                'message' => 'You are not authorized to access this page.',
                'type' => 'error'
            ]);
        }

        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->get();

        return view('my-orders', [
            'orders' => $orders,
            'subcategories' => $this->getAllSubcategories()
        ]);
    }

    public function renderViewOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with([
                'message' => 'You are not authorized to access this page.',
                'type' => 'error'
            ]);
        }

        $user = Auth::user();
        $trackingNo = $request->trackingNo;
        $order = Order::where('tracking_no', $trackingNo)->where('user_id', $user->id)->first();

        if (!$order) {
            return redirect()->back()->with([
                'message' => 'Tracking number does not exist.',
                'type' => 'error'
            ]);
        }

        // Retrieve order items associated with the order
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        return view('view-order', [
            'order' => $order,
            'orderItems' => $orderItems,
            'subcategories' => $this->getAllSubcategories()
        ]);
    }

    // Get all active subcategories
    private function getAllSubcategories()
    {
        return SubCategory::where('status', 1)->get();
    }
}
