<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function renderCheckout()
    {
        if (!Auth::check()) {
            return redirect()->back()->with([
                'message' => 'You are not authorized to access this page.',
                'type' => 'error'
            ]);
        }

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->orderByDesc('created_at')->get();
        $totalPrice = 0;

        if ($cartItems) {
            foreach ($cartItems as $citem) {
                $productTotalPrice = $citem->product->selling_price * $citem->product_quantity;
                $totalPrice += $productTotalPrice;
            }
        } else {
            return redirect()->back()->with([
                'message' => 'There are no items in the cart.',
                'type' => 'error'
            ]);
        }

        return view('checkout', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'subcategories' => $this->getAllSubcategories()
        ]);
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with([
                'message' => 'You are not authorized to access this page.',
                'type' => 'error'
            ]);
        }

        $name = $request->name;
        $email = $request->email;
        $contactNo = $request->contact_no;
        $address = $request->address;
        $zip = $request->zip;
        $payment = $request->payment;

        $trackingNo = 'soleace' . uniqid();
        $user = Auth::user();

        $cartItems = Cart::where('user_id', $user->id)->orderByDesc('created_at')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with([
                'message' => 'There are no items in the cart.',
                'type' => 'error'
            ]);
        }

        $totalPrice = 0;
        foreach ($cartItems as $citem) {
            $productTotalPrice = $citem->product->selling_price * $citem->product_quantity;
            $totalPrice += $productTotalPrice;
        }

        // Create the order
        $order = Order::create([
            'tracking_no' => $trackingNo,
            'user_id' => $user->id,
            'name' => $name,
            'email' => $email,
            'phone' => $contactNo,
            'address' => $address,
            'zip_code' => $zip,
            'total_price' => $totalPrice,
            'payment_method' => $payment,
            'payment_id' => null,
        ]);

        if ($order) {
            // Loop through cart items to create order items and update product quantities
            foreach ($cartItems as $citem) {
                $product = Product::find($citem->product_id);
                if ($product) {
                    // Create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $citem->product_id,
                        'product_size' => $citem->product_size,
                        'product_quantity' => $citem->product_quantity,
                        'product_price' => $citem->product->selling_price,
                    ]);

                    // Update product quantity
                    $product->quantity -= $citem->product_quantity;
                    $product->save();
                }
            }

            // Delete cart items
            Cart::where('user_id', $user->id)->delete();

            return redirect()->route('myOrder.render')->with([
                'message' => 'Order placed successfully.',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something went wrong.',
                'type' => 'error'
            ]);
        }
    }

    // Get all active subcategories
    private function getAllSubcategories()
    {
        return SubCategory::where('status', 1)->get();
    }
}
