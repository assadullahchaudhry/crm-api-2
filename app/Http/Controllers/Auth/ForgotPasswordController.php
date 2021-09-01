<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordLinkEmail;


class ForgotPasswordController extends Controller
{
    public function sendPasswordResetLink(Request $request)
    {

        $this->validate(request(), [
            'email' => 'required|email'
        ]);

        $user = User::where('email', request()->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User with the email does not exist'
            ], 404);
        }

        DB::table('auc_password_resets')->where('email', request()->email)->delete();

        $token = uuid();

        $passwordReset = new PasswordReset;
        $passwordReset->email = $user->email;
        $passwordReset->token = $token;

        if (!$passwordReset->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error has occured while sending the password reset email!'
            ], 500);
        }

        Mail::to($user)->queue(new ForgotPasswordLinkEmail($user, $passwordReset->token));

        return response()->json([
            'status' => 'success',
            'message' => 'Email with password reset link has been sent!'
        ], 200);
    }
    public function resetPassword(Request $request)
    {
        $this->validate(request(), [
            'id' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirmPassword' => 'required'
        ]);

        if (request()->password !== request()->confirmPassword) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mismatch password and confirm password'
            ], 400);
        }

        $user = User::where('email', request()->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User with the email does not exist'
            ], 404);
        }

        $passwordReset = PasswordReset::where('token', request()->id)->where('email', request()->email)->first();

        if (!$passwordReset) {

            $token = uuid();

            $passwordReset = new PasswordReset;
            $passwordReset->email = $user->email;
            $passwordReset->token = $token;
            $passwordReset->save();

            Mail::to($user)->queue(new ForgotPasswordLinkEmail($user, $passwordReset->token));

            return response()->json([
                'status' => 'success',
                'message' => 'Link expired. We have sent an email with a new password reset link!'
            ], 200);
        }

        $user->password = bcrypt(request()->password);

        if (!$user->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error has occured while resetting the password'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Password has been updated successfully!'
        ], 200);
    }
}
