<?php

namespace App\Http\Controllers;


use App\Models\Group;
use App\Models\GroupLocation;
use App\Models\GroupPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
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

            $items = Group::orderBy('name', 'asc')
                ->where('name', 'like', $query)
                ->orWhere('email', 'like', $query)
                ->skip($offset)
                ->take($limit)
                ->get();
        } else {
            $items = Group::orderBy('name', 'asc')->skip($offset)->take($limit)->get();
        }

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Group::count(),
                'items' => $items
            ],

        ], 200);
    }

    //get single model
    public function show($id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Group not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'item' => $group,

        ], 200);
    }



    //store model
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required',
            'fax' => 'required',
            'address' => 'required',
            'cityId' => 'required',
            'stateId' => 'required',
            'countryId' => 'required',
            'postalCode' => 'required'

        ]);

        $group = Group::where('name', request()->name)->first();

        if ($group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Group name already exists'
            ], 422);
        }


        $group = new Group;
        $group->id = getRandomId();
        $group->name = request()->name;
        $group->email = request()->email;

        if (!$group->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing group'
            ], 500);
        }

        $location = new GroupLocation;
        $location->groupId = $group->id;
        $location->address = request()->address;
        $location->cityId = request()->cityId;
        $location->stateId = request()->stateId;
        $location->countryId = request()->countryId;
        $location->postalCode = request()->postalCode;

        if (!$location->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing location details'
            ], 500);
        }

        $phone = new GroupPhone;
        $phone->groupId = $group->id;
        $phone->phone = request()->phone;
        $phone->type = 'Phone';


        if (!$phone->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing phone'
            ], 500);
        }

        $phone = new GroupPhone;
        $phone->groupId = $group->id;
        $phone->phone = request()->fax;
        $phone->type = 'Fax';


        if (!$phone->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing fax'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Group created successfully!'
        ], 200);
    }

    //update a user
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required',
            'fax' => 'required',
            'address' => 'required',
            'cityId' => 'required',
            'stateId' => 'required',
            'countryId' => 'required',
            'postalCode' => 'required'

        ]);

        $group = Group::where('name', request()->name)->first();

        if ($group and $group->id != $id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Group name already exists'
            ], 422);
        }

        $group->name = request()->name;
        $group->email = request()->email;

        if (!$group->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing group'
            ], 500);
        }

        $location = GroupLocation::where('groupId', $id)->first();

        if (!$location) {
            $location = new GroupLocation;
        }

        $location->groupId = $group->id;
        $location->address = request()->address;
        $location->cityId = request()->cityId;
        $location->stateId = request()->stateId;
        $location->countryId = request()->countryId;
        $location->postalCode = request()->postalCode;

        if (!$location->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating location details'
            ], 500);
        }

        $phone = GroupPhone::where('groupId', $id)->where('type', 'Phone')->first();

        if (!$phone) {
            $phone = new GroupPhone;
            $phone->groupId = $group->id;
            $phone->type = 'Phone';
        }

        $phone->phone = request()->phone;


        if (!$phone->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating phone'
            ], 500);
        }

        $phone = GroupPhone::where('groupId', $id)->where('type', 'Fax')->first();

        if (!$phone) {
            $phone = new GroupPhone;
            $phone->groupId = $group->id;
            $phone->type = 'Fax';
        }

        $phone->phone = request()->phone;


        if (!$phone->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating fax'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Group updated successfully!'
        ], 200);
    }

    //delete a user
    public function destroy($id)
    {
        $group = Group::find($id);

        if (!$group) {

            return response()->json([
                'status' => 'error',
                'message' => 'Group does not exist!',
            ], 404);
        }

        if (!$group->delete()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting group!',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Group deleted successfully!',
        ], 200);
    }
}
