<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $token = oauthLogin(request()->email, request()->password);

        return $token;
        $user = User::where('email', request()->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect email or password'
            ], 400);
        }

        return $token;
    }
    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->each(function ($token) {
                $token->delete();
            });

            return response()->json(['status' => 'success', 'message' => 'You are logged out successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error has occured while logging out'], 500);
        }
    }
}
