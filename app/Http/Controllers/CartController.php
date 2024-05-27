<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function renderCart()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->orderByDesc('created_at')->get();
        $totalPrice = 0;


        if ($cartItems) {
            foreach ($cartItems as $citem) {
                $productTotalPrice = $citem->product->selling_price * $citem->product_quantity;
                $totalPrice += $productTotalPrice;
            }
        }

        return view('cart', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'subcategories' => $this->getAllSubcategories(),
        ]);
    }

    // Add items to cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'product_size' => 'required|integer',
            'product_quantity' => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            return redirect()->route('sign-in.render')->with([
                'message' => 'You need to be signed in to add items to your cart.',
                'type' => 'error'
            ]);
        }

        $user = Auth::user();

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('product_size', $request->product_size)
            ->first();

        if ($cartItem) {
            $cartItem->product_quantity += $request->product_quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'product_size' => $request->product_size,
                'product_quantity' => $request->product_quantity,
            ]);
        }

        return response()->json([
            'type' => 'success',
            'message' => 'Product added to cart successfully!',
        ]);
    }

    // Update items from cart
    public function updateFromCart(Request $request)
    {
        $productId = $request->id;
        $productSize = $request->product_size;
        $productQuantity = $request->product_quantity;

        if (!Auth::check()) {
            return response()->json([
                'type' => 'error',
                'message' => 'You need to be signed in to update items in your cart.'
            ]);
        }

        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            if ($productSize) {
                $cartItem->product_size = $productSize;
            }
            if ($productQuantity) {
                $cartItem->product_quantity = $productQuantity;
            }
            $cartItem->save();

            // Recalculate the total price
            $cartItems = Cart::where('user_id', $user->id)->get();
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $totalPrice += $item->product->selling_price * $item->product_quantity;
            }

            return response()->json([
                'type' => 'success',
                'message' => 'Cart updated successfully!',
                'totalPrice' => number_format($totalPrice, 2)
            ]);
        } else {
            return response()->json([
                'type' => 'error',
                'message' => 'Product not found in cart.'
            ]);
        }
    }


    // Delete items from cart
    public function deleteFromCart(Request $request)
    {
        $productId = $request->id;

        if (!Auth::check()) {
            return redirect()->route('sign-in.render')->with([
                'message' => 'You need to be signed in to delete items from your cart.',
                'type' => 'error'
            ]);
        }

        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.render')->with([
                'message' => 'Product removed from cart successfully!',
                'type' => 'success'
            ]);
        }
        return redirect()->route('cart.render')->with([
            'message' => 'Product not found in cart.',
            'type' => 'error'
        ]);
    }

    // Get all active subcategories
    private function getAllSubcategories()
    {
        return SubCategory::where('status', 1)->get();
    }
}
