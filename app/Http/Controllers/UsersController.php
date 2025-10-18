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
        // ✅ جلب بيانات السلة من الـ frontend مباشرة (مش من session)
        $cart = session()->get('cart');
        Log::info('Cart: '.json_encode($cart));
        // ✅ إنشاء أو استرجاع المستخدم حسب الإيميل
        $user = User::firstOrCreate(
            ['email' => $request->input('email')],
            [
                'password' => Hash::make(Str::random(12)),
                'name' => $request->input('first_name').' '.$request->input('last_name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('zip_code'),
            ]
        );

        try {
            // ✅ إنشاء Stripe Customer (إن لم يكن موجود)
            $user->createOrGetStripeCustomer();

            Stripe::setApiKey(config('services.stripe.secret'));

            // ✅ إنشاء الدفع بدون redirect
            $paymentIntent = PaymentIntent::create([
                'amount' => intval($request->input('amount') * 100), // Stripe يستخدم القروش
                'currency' => 'usd',
                'customer' => $user->stripe_id,
                'payment_method' => $request->input('payment_method_id'),
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // ⛔️ لا تسمح بالـ redirect
                ],
            ]);
            Log::info('PaymentIntent created: '.$paymentIntent);
            // ✅ حفظ الطلب في قاعدة البيانات
            $order = $user->orders()->create([
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
