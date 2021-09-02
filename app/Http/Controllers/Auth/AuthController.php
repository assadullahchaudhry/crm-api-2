<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\BadResponseException;




class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $client = new Client();

        $url = url('/v1/oauth/token');

        try {
            // $response =  $client->post($url, [
            //     'form_params' => [
            //         'client_secret' => 'nv7Lzi3o74pNWL7qleLGEaXKnH79aJshQjzoV2zj',
            //         'client_id' => 2,
            //         'grant_type' => 'password',
            //         'username' => request()->email,
            //         'password' => request()->password
            //     ]
            // ]);

            $response =  $client->request('POST', $url, [
                // 'headers' => [
                //     'cache-control' => 'no-cache',
                //     'Content-Type' => 'application/x-www-form-urlencoded'
                // ],
                'form_params' => [
                    'client_secret' => 'nv7Lzi3o74pNWL7qleLGEaXKnH79aJshQjzoV2zj',
                    'client_id' => 2,
                    'grant_type' => 'password',
                    'username' => request()->email,
                    'password' => request()->password
                ]
            ]);
            return $response;
        } catch (BadResponseException $e) {
            return response()->json($e);
        }


        // $token = oauthLogin(request()->email, request()->password);

        // return $token;
        // $user = User::where('email', request()->email)->first();

        // if (!$user) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Incorrect email or password'
        //     ], 400);
        // }

        // return $token;
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
