<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $limit = 10;
        $offset = 0;

        if (request()->has('page') and request()->has('limit')) {
            $limit = request()->limit;
            $offset = request()->page * $limit;
        }



        if (request()->has('q')) {

            $query = '%' . request()->q . '%';

            $users = User::orderBy('firstName', 'asc')
                ->where('firstName', 'like', $query)
                ->orWhere('lastName', 'like', $query)
                ->orWhere('email', 'like', $query)
                ->skip($offset)
                ->take($limit)
                ->get();
        } else {
            $users = User::orderBy('firstName', 'asc')->skip($offset)->take($limit)->get();
        }

        return response()->json([
            'status' => 'success',
            'users' => [
                'total' => User::count(),
                'items' => $users
            ],

        ], 200);
    }

    public function getCurrentlyLoggedInUser()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please log in to your account.'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => '',
            'user' => $user
        ], 200);
    }

    //get one user
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'total' => User::count()

        ], 200);
    }



    //store user
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required',
            'password' => 'required|min:8',
            'confirmPassword' => 'required',
            'role' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'All fields are required'
            ], 422);
        }

        $user = User::where('email', request()->email)->first();

        if ($user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email address already in use'
            ], 422);
        }

        if (request()->password !== request()->confirmPassword) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mismatch password and confirm password'
            ], 422);
        }

        $role = Role::where('name', request()->role)->first();

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role does not exist'
            ], 404);
        }

        $user = User::create([
            'id' => getRandomId(),
            'firstName' => request()->firstName,
            'lastName' => request()->lastName,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
            'roleId' => $role->id

        ]);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating record!'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Record created successfully!'
        ], 200);
    }

    //update a user

    public function update(Request $request, $id)
    {

        $user = User::find($id);

        $validator = Validator::make($request->all(), [

            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => "Required fields are missing"
            ], 422);
        }


        $user = User::where('email', request()->email)->where('id', '<>', $id)->first();

        if ($user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email address already in use'
            ], 400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not exist'
            ], 404);
        }

        $role = Role::where('name', request()->role)->first();

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role does not exist'
            ], 404);
        }

        $user->firstName = request()->firstName;
        $user->lastName = request()->lastName;
        $user->email = request()->email;
        $user->roleId = $role->id;

        if (request()->password and request()->confirmPassword) {
            if (request()->password !== request()->confirmPassword) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mismatch password and confirm password'
                ], 422);
            }

            $user->password = bcrypt(request()->password);
        }


        if (!$user->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating record!'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Record updated successfully'
        ], 200);
    }

    //delete a user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {

            return response()->json([
                'status' => 'error',
                'message' => 'Record does not exist!',
            ], 404);
        }

        if (!$user->delete()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting record!',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Record deleted successfully!',
        ], 200);
    }
}
