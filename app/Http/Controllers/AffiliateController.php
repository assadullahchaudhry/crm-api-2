<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index()
    {
        $limit = 10;
        $offset = 0;

        if (request()->has('page') and request()->has('limit')) {
            $limit = request()->limit;
            $offset = request()->page * $limit;
        }


        if (request()->has('q')) {

            $query = '%' . request()->q . '%';

            $items = Affiliate::orderBy('firstName', 'asc')
                ->where('firstName', 'like', $query)
                ->orWhere('lastName', 'like', $query)
                ->orWhere('email', 'like', $query)
                ->orWhere('phone', 'like', $query)
                ->orWhere('company', 'like', $query)
                ->skip($offset)
                ->take($limit)
                ->get();
        } else {
            $items = Affiliate::orderBy('firstName', 'asc')->skip($offset)->take($limit)->get();
        }

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Affiliate::count(),
                'items' => $items
            ],

        ], 200);
    }



    //get one user
    public function show($id)
    {
        $affiliate = Affiliate::find($id);

        if (!$affiliate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'item' => $affiliate,
            'total' => Affiliate::count()
        ], 200);
    }

    //create
    public function store(Request $request)
    {
        $this->validate(request(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'company' => 'required'
        ]);


        $affiliate = new Affiliate;
        $affiliate->id = getRandomId();
        $affiliate->firstName = request()->firstName;
        $affiliate->lastName = request()->lastName;
        $affiliate->email = request()->email;
        $affiliate->phone = request()->phone;
        $affiliate->company = request()->company;


        if (!$affiliate->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing affiliate'
            ], 500);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Affiliate created successfully!'
        ], 200);
    }

    //update
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'company' => 'required'
        ]);

        $affiliate = Affiliate::find($id);

        if (!$affiliate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Affiliate does not exist'
            ], 500);
        }

        $affiliate = Affiliate::where('email', request()->email)->first();

        if ($affiliate->id != $id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Affiliate with the same email already exists'
            ], 500);
        }

        $affiliate->firstName = request()->firstName;
        $affiliate->lastName = request()->lastName;
        $affiliate->email = request()->email;
        $affiliate->phone = request()->phone;
        $affiliate->company = request()->company;


        if (!$affiliate->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing affiliate'
            ], 500);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Affiliate created successfully!'
        ], 200);
    }

    //delete a user

    public function destroy($id)
    {
        $affiliate = Affiliate::find($id);

        if (!$affiliate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Affiliate does not exist!',
            ], 404);
        }

        if (!$affiliate->delete()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting affiliate!',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Affiliate deleted successfully!',
        ], 200);
    }
}
