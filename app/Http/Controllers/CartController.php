<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart =  session()->get('cart', []);
        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => array_values($cart),
            'total' => $this->calculateTotal($cart),
            'length' => count($cart),
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);

        if (! $product) {
            abort(404);
        }

        // Get the current cart or initialize empty
        $cart =  session()->get('cart', []);

        // Log for debugging
        \Log::info('Cart before update: ' . json_encode($cart));

        // If the product is already in the cart, increment its quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // If not, add it with quantity 1
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
                'id' => $product->id,
            ];
        }

        // Save the updated cart to session
         session()->put('cart', $cart);

        // Optional: log result
        \Log::info('Cart after update: ' . json_encode($cart));

        return response()->json([
            'message' => 'Product added to cart successfully!',
            'cart' => array_values($cart),
            'total' => $this->calculateTotal($cart),
            'length' => count($cart),
        ]);
    }


    public function removeFromCart(Request $request, $id)
    {

        $cart =  session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
             session()->put('cart', $cart);

            return response()->json([
                'message' => 'Product Deleted to cart successfully!',
                'cart' => array_values($cart),
                'total' => $this->calculateTotal($cart),
                'length' => count($cart),
            ]);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }

    public function clear(Request $request)
    {
         session()->forget('cart');

        return response()->json([
            'message' => 'Cart cleared',
            'cart' => [],
            'total' => 0,
        ]);
    }

    private function calculateTotal($cart)
    {
        return array_reduce($cart, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function incrementQuantity(Request $request)
    {
        $cart =  $request->session()->get('cart', []);

        foreach ($cart as &$item) {
            if ($item['id'] ==  $request->id) {
                $item['quantity']++;
                break;
            }
        }

         $request->session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product Update to cart successfully!',
            'cart' => array_values($cart),
            'total' => $this->calculateTotal($cart),
            'length' => count($cart),
        ]);
    }

    public function decrementQuantity(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        foreach ($cart as &$item) {
            if ($item['id'] ==  $request->id) {
                if ($item['quantity'] > 1) {
                    $item['quantity']--;
                }
                break;
            }
        }

        $request->session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product Update to cart successfully!',
            'cart' => array_values($cart),
            'total' => $this->calculateTotal($cart),
            'length' => count($cart),
        ]);
    }
}
