<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
        }
        $cartItems = CartItem::where('user_id', $user->id)->get();
        return view('cart', compact('cartItems'));
    }

    public function addToCart(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Please log in to add items to your cart.'], 401);
        }
        $quantity = $request->input('quantity', 1);
        // Check if the item already exists in the user's cart
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $id)
            ->first();
        if ($cartItem) {
            // Update the quantity if the item is already in the cart
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
        } else {
            // Create a new cart item if it doesn't exist
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $id,
                'quantity' => $quantity,
            ]);
        }

        return response()->json(['message' => 'Product added to cart']);
    }


    public function updateCart(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        $this->updateCart($id, $quantity);
        return response()->json(['message' => 'Cart item updated successfully']);
    }

    public function removeFromCart($id)
    {
        $user = Auth::user();
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Cart item removed successfully']);
        }

        return redirect()->route('cart.index')->with('error', 'Cart item not found');
    }

    public function checkout()
    {
        $user = Auth::user();
        $cartItems = $this->getCartItems();
    
        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty']);
        }
    
        // Calculate the total cost of items in the cart
        $totalCost = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });
    
        // Implement your payment processing logic here.
        // For simplicity, we'll assume the payment is successful.
    
        // Create an order or perform any other necessary actions here.
        // You may want to create an Order model and store order details in your database.
    
        // Clear the cart after successful checkout
        $this->clearCart();
    
        return response()->json(['message' => 'Checkout Successful' . $totalCost]);
    
    }
}