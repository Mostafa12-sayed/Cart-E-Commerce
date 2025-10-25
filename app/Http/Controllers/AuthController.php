<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login the user after registration
        Auth::login($user);

        // Cart persists in session automatically - no transfer needed!
//        $cart = session('cart', []);
//        session(['cart' => $cart]);
        $oldCart = session('cart');
        $request->session()->regenerate();
        session(['cart' => $oldCart]); // ✅ رجّع السلة
        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 201);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Cart stays in session - automatically preserved!
            $oldCart = session('cart');
            $request->session()->regenerate();
            session(['cart' => $oldCart]); // ✅ رجّع السلة
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Store cart before invalidating session
        $cart = $request->session()->get('cart', []);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Restore cart to new session
        $request->session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
            'cart' => $cart,
        ]);
    }

    public function user(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'cart' => $request->session()->get('cart', []),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated',
            'cart' => $request->session()->get('cart', []),
        ], 401);
    }

    public function check(Request $request)
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::check() ? [
                'id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ] : null,
        ]);
    }

    public function recoverPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email:filter',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }


    }

}
