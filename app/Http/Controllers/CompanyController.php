<?php

namespace App\Http\Controllers;


use App\Models\Group;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\CompanyContact;
use App\Models\CompanyLocation;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        // $limit = 10;
        // $offset = 0;

        // if (request()->has('page') and request()->has('limit')) {
        //     $limit = request()->limit;
        //     $offset = request()->page * $limit;
        // }


        // if (request()->has('q')) {

        //     $query = '%' . request()->q . '%';

        //     $items = Company::orderBy('name', 'asc')
        //         ->where('name', 'like', $query)
        //         ->orWhere('ownerName', 'like', $query)
        //         ->orWhere('shipstationUsername', 'like', $query)
        //         ->orWhere('apEmail', 'like', $query)
        //         ->skip($offset)
        //         ->take($limit)
        //         ->get();
        // } else {
        //     $items = Company::orderBy('name', 'asc')->skip($offset)->take($limit)->get();
        // }

        $items = Company::orderBy('name', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Company::count(),
                'items' => $items
            ],

        ], 200);

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Company::count(),
                'items' => $items
            ],

        ], 200);
    }
    public function refs()
    {
        $contacts = Contact::select('id', 'firstName', 'lastName')->orderBy('firstName', 'asc')->get();
        $groups = Group::select('id', 'name')->orderBy('name', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'contacts' => $contacts,
            'groups' => $groups
        ], 200);
    }

    //get single model
    public function show($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'item' => $company,
            'total' => Company::count()
        ], 200);
    }



    //store model
    public function store(Request $request)
    {
        $this->validate(request(), [
            'groupId' => 'required',
            'name' => 'required|string',
            'apEmail' => 'required|string',
            'shipstationUsername' => 'required',
            'ownerName' => 'required',
            'address' => 'required',
            'cityId' => 'required',
            'stateId' => 'required',
            'countryId' => 'required',
            'postalCode' => 'required',
            'contactId' => 'required',
            'billingContactId' => 'required',
            'doContactId' => 'required',
            'supportContactId' => 'required'
        ]);

        $company = Company::where('name', request()->name)->first();

        if ($company) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company name already exists'
            ], 422);
        }

        $group = Group::find(request()->groupId);

        if (!$group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Group does not exist'
            ], 422);
        }




        $company = new Company;
        $company->id = getRandomId();
        $company->groupId = request()->groupId;
        $company->name = request()->name;
        $company->apEmail = request()->apEmail;
        $company->ownerName = request()->ownerName;
        $company->shipstationUsername = request()->shipstationUsername;
        // $company->contactId = request()->contactId;
        // $company->doContactId = request()->doContactId;
        // $company->billingContactId = request()->billingContactId;
        // $company->supportContactId = request()->supportContactId;

        if (!$company->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing company'
            ], 500);
        }


        $contact = Contact::find(request()->contactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact does not exist'
            ], 422);
        }

        $contact->type = 'contact';
        $contact->companyId = $company->id;

        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing contact'
            ], 422);
        }


        $contact = Contact::find(request()->doContactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'DO contact does not exist'
            ], 422);
        }

        $contact->type = 'do';
        $contact->companyId = $company->id;

        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing DO contact'
            ], 422);
        }

        $contact = Contact::find(request()->billingContactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Billing contact does not exist'
            ], 422);
        }

        $contact->type = 'billing';
        $contact->companyId = $company->id;

        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing billing contact'
            ], 422);
        }

        $contact = Contact::find(request()->supportContactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Support contact does not exist'
            ], 422);
        }

        $contact->type = 'support';
        $contact->companyId = $company->id;

        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing support contact'
            ], 422);
        }



        $location = new CompanyLocation;
        $location->companyId = $company->id;
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


        return response()->json([
            'status' => 'success',
            'message' => 'Company created successfully!'
        ], 200);
    }

    //update 
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'groupId' => 'required',
            'name' => 'required|string',
            'apEmail' => 'required|string',
            'shipstationUsername' => 'required',
            'ownerName' => 'required',
            'address' => 'required',
            'cityId' => 'required',
            'stateId' => 'required',
            'countryId' => 'required',
            'postalCode' => 'required',
            'contactId' => 'required',
            'billingContactId' => 'required',
            'doContactId' => 'required',
            'supportContactId' => 'required'
        ]);

        $company = Company::where('name', request()->name)->first();

        if ($company and $company->id != $id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company name already exists'
            ], 422);
        }

        $company = Company::find($id);

        if (!$company) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company does not exist'
            ], 422);
        }

        $group = Group::find(request()->groupId);

        if (!$group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Group does not exist'
            ], 422);
        }



        $company->groupId = request()->groupId;
        $company->name = request()->name;
        $company->apEmail = request()->apEmail;
        $company->ownerName = request()->ownerName;
        $company->shipstationUsername = request()->shipstationUsername;
        // $company->contactId = request()->contactId;
        // $company->doContactId = request()->doContactId;
        // $company->billingContactId = request()->billingContactId;
        // $company->supportContactId = request()->supportContactId;

        if (!$company->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing company'
            ], 500);
        }

        $contacts = $company->contacts;

        if ($contacts->count()) {
            foreach ($contacts as $c) {
                $c->type = null;
                $c->companyId = null;
                $c->save();
            }
        }

        $contact = Contact::find(request()->contactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact does not exist'
            ], 422);
        }

        $contact->type = 'contact';
        $contact->companyId = $company->id;

        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing contact'
            ], 422);
        }


        $contact = Contact::find(request()->doContactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'DO contact does not exist'
            ], 422);
        }

        $contact->type = 'do';
        $contact->companyId = $company->id;

        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing DO contact'
            ], 422);
        }

        $contact = Contact::find(request()->billingContactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Billing contact does not exist'
            ], 422);
        }

        $contact->type = 'billing';
        $contact->companyId = $company->id;

        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing billing contact'
            ], 422);
        }

        $contact = Contact::find(request()->supportContactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Support contact does not exist'
            ], 422);
        }

        $contact->type = 'support';
        $contact->companyId = $company->id;

        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing support contact'
            ], 422);
        }



        $location = CompanyLocation::where('companyId', $id)->first();

        if (!$location) {
            $location = new CompanyLocation;
        }

        $location->companyId = $company->id;
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

        return response()->json([
            'status' => 'success',
            'message' => 'Company updated successfully!'
        ], 200);
    }

    //delete
    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {

            return response()->json([
                'status' => 'error',
                'message' => 'Company does not exist!',
            ], 404);
        }

        if (!$company->delete()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting company!',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Company deleted successfully!',
        ], 200);
    }
}
