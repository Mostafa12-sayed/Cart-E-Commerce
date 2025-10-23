<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class UsersController extends Controller
{
    public function purchase(Request $request)
    {
        $cart = session()->get('cart');
        $loginUser =auth()->user();
        $user = $loginUser->update([
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('zip_code'),
            ]
        );

        try {
            // ✅ إنشاء Stripe Customer (إن لم يكن موجود)
            $loginUser->createOrGetStripeCustomer();

            Stripe::setApiKey(config('services.stripe.secret'));

            // ✅ إنشاء الدفع بدون redirect
            $paymentIntent = PaymentIntent::create([
                'amount' => intval($request->input('amount') * 100), // Stripe يستخدم القروش
                'currency' => 'usd',
                'customer' => $loginUser->stripe_id,
                'payment_method' => $request->input('payment_method_id'),
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // ⛔️ لا تسمح بالـ redirect
                ],
            ]);
            Log::info('PaymentIntent created: '.$paymentIntent);
            // ✅ حفظ الطلب في قاعدة البيانات
            $order = $loginUser->orders()->create([
                'transaction_id' => $paymentIntent->id,
                'total' => $paymentIntent->amount,
            ]);

            foreach ($cart as $item) {
                $order->products()->attach($item['id'], ['quantity' => $item['quantity']]);
            }
            session()->forget('cart'); // ⛔️ حذف السلة من الـ session
            $order->load('products');

            Log::info('Order created: '.$order);
            return response()->json([
                'status' => 'success',
                'order' => $order,
                'payment_status' => $paymentIntent->status,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
