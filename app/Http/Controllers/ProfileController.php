<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{

    public function updatePassword(Request $request)
    {
        $this->validate(request(), [
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string',
            'confirmPassword' => 'nullable',
        ]);



        $user = User::find(auth()->user()->id);

        if (!Hash::check(request()->currentPassword, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect current password'
            ], 400);
        }

        if (request()->newPassword != request()->confirmPassword) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mismatch new and confirm passwords'
            ], 400);
        }

        $user->password = bcrypt(request()->newPassword);

        if (!$user->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating password'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully!',
        ], 200);
    }

    public function avatarUpdate(Request $request)
    {
        $this->validate(request(), [
            'avatar' => 'required|image'
        ]);

        $destination = '/uploads/user/' . auth()->user()->id;

        $file = uploadFile(request(), 'avatar', $destination);

        if (!$file) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing avatar'
            ], 500);
        }

        $user = User::find(auth()->user()->id);

        $filePath = base_path('/public' . $user->avatar);

        if ($user->avatar and file_exists($filePath)) {
            @unlink($filePath);
        }

        $user->avatar = $file['path'];

        if (!$user->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing avatar'
            ], 500);
        }

        $user = User::find($user->id);


        return response()->json([
            'status' => 'success',
            'message' => 'Profile info updated successfully!',
            'user' => $user
        ], 200);
    }

    public function update(Request $request)
    {

        $this->validate(request(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',

            'phone' => 'nullable',
            'mobile' => 'nullable',
            'fax' => 'nullable',
            'address' => 'nullable'
        ]);

        $user = User::find(auth()->user()->id);

        $user->firstName = request()->firstName;
        $user->lastName = request()->lastName;

        if (request()->address) {
            $user->address = request()->address;
        }

        if (request()->phone) {
            $phone = UserPhone::where('userId', $user->id)->where('type', 'phone')->first();

            if (!$phone) {
                $phone  = new UserPhone;
            }

            $phone->phone = request()->phone;
            $phone->type = 'Phone';
            $phone->userId = $user->id;

            if (!$phone->save()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error updating phone'
                ], 500);
            }
        }

        if (request()->mobile) {
            $phone = UserPhone::where('userId', $user->id)->where('type', 'mobile')->first();

            if (!$phone) {
                $phone  = new UserPhone;
            }

            $phone->phone = request()->mobile;
            $phone->type = 'Mobile';
            $phone->userId = $user->id;

            if (!$phone->save()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error updating mobile'
                ], 500);
            }
        }

        if (request()->fax) {
            $phone = UserPhone::where('userId', $user->id)->where('type', 'fax')->first();

            if (!$phone) {
                $phone  = new UserPhone;
            }

            $phone->phone = request()->fax;
            $phone->type = 'Fax';
            $phone->userId = $user->id;

            if (!$phone->save()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error updating fax'
                ], 500);
            }
        }



        if (!$user->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating profile info'
            ], 500);
        }

        $user = User::find($user->id);


        return response()->json([
            'status' => 'success',
            'message' => 'Profile info updated successfully!',
            'user' => $user
        ], 200);
    }
}
