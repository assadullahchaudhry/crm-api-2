<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactPhone;
use Illuminate\Http\Request;
use App\Models\ContactLocation;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        // $limit = 100;
        // $offset = 0;

        // if (request()->has('page') and request()->has('limit')) {
        //     $limit = request()->limit;
        //     $offset = request()->page * $limit;
        // }


        // if (request()->has('q')) {

        //     $query = '%' . request()->q . '%';

        //     $items = Contact::orderBy('firstName', 'asc')
        //         ->where('firstName', 'like', $query)
        //         ->orWhere('lastName', 'like', $query)
        //         ->orWhere('email', 'like', $query)
        //         ->skip($offset)
        //         ->take($limit)
        //         ->get();
        // } else {
        //     $items = Contact::orderBy('firstName', 'asc')->skip($offset)->take($limit)->get();
        // }

        $items = Contact::orderBy('name', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Contact::count(),
                'items' => $items
            ],

        ], 200);
    }

    public function refs()
    {
        $companies = Company::select('id', 'name')->orderBy('name', 'asc')->get();


        return response()->json([
            'status' => 'success',
            'companies' => $companies,
        ], 200);
    }


    //get one user

    public function show($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'item' => $contact,
            'total' => Contact::count()
        ], 200);
    }

    //create
    public function store(Request $request)
    {
        $this->validate(request(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'contactType' => 'nullable',
            'phone' => 'required|string',
            'phoneExtension' => 'nullable',
            'companyId' => 'nullable',
            'mobile' => 'required',
            'fax' => 'required',
            'address' => 'required',
            'cityId' => 'required',
            'stateId' => 'required',
            'countryId' => 'required',
            'postalCode' => 'required'
        ]);

        if (request()->companyId and !request()->contactType) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have selected company but did not select contact type'
            ], 422);
        }

        if (!request()->companyId and request()->contactType) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have selected contact type but did not select company'
            ], 422);
        }


        $contact = new Contact;
        $contact->id = getRandomId();
        $contact->firstName = request()->firstName;
        $contact->lastName = request()->lastName;
        $contact->email = request()->email;


        $company = null;

        if (request()->companyId) {
            $company = Company::find(request()->companyId);
            if (!$company) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Company does not exist'
                ], 404);
            }

            $contact->companyId = $company->id;
            $contact->type = request()->contactType;
        }


        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing contact'
            ], 500);
        }

        $location = new ContactLocation;
        $location->contactId = $contact->id;
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


        $phone = new ContactPhone;
        $phone->contactId = $contact->id;
        $phone->phone = request()->phone;
        $phone->type = 'Phone';
        $phone->extension = request()->phoneExtension;


        if (!$phone->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing phone'
            ], 500);
        }

        $phone = new ContactPhone;
        $phone->contactId = $contact->id;
        $phone->phone = request()->mobile;
        $phone->type = 'Mobile';

        if (!$phone->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing mobile'
            ], 500);
        }

        $phone = new ContactPhone;
        $phone->contactId = $contact->id;
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
            'message' => 'Contact created successfully!'
        ], 200);
    }

    //update
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'contactType' => 'nullable',
            'phone' => 'required|string',
            'phoneExtension' => 'nullable',
            'companyId' => 'nullable',
            'mobile' => 'required',
            'fax' => 'required',
            'address' => 'required',
            'cityId' => 'required',
            'stateId' => 'required',
            'countryId' => 'required',
            'postalCode' => 'required'
        ]);

        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact does not exist'
            ], 404);
        }

        if (request()->companyId and !request()->contactType) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have selected company but did not select contact type'
            ], 422);
        }

        if (!request()->companyId and request()->contactType) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have selected contact type but did not select company'
            ], 422);
        }

        $contact->firstName = request()->firstName;
        $contact->lastName = request()->lastName;
        $contact->email = request()->email;


        $company = null;

        if (request()->companyId) {
            $company = Company::find(request()->companyId);
            if (!$company) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Company does not exist'
                ], 404);
            }

            $contact->companyId = $company->id;
            $contact->type = request()->contactType;
        }


        if (!$contact->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing contact'
            ], 500);
        }

        $location = ContactLocation::where('contactId', $contact->id)->first();

        if (!$location) {
            $location = new ContactLocation;
        }

        $location->contactId = $contact->id;
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

        $phones = ContactPhone::where('contactId', $contact->id)->get();

        if ($phones->count()) {
            foreach ($phones as $phone) {
                if (strtolower($phone->type) == 'phone' and $phone->phone != request()->phone) {
                    $phone->phone = request()->phone;
                    $phone->extension = request()->phoneExtension;
                } else  if (strtolower($phone->type) == 'mobile' and $phone->phone != request()->mobile) {
                    $phone->phone = request()->mobile;
                } else if (strtolower($phone->type) == 'fax' and $phone->phone != request()->fax) {
                    $phone->phone = request()->fax;
                }
                $phone->save();
            }
        } else {

            $phone = new ContactPhone;
            $phone->contactId = $contact->id;
            $phone->phone = request()->phone;
            $phone->type = 'Phone';
            $phone->extension = request()->phoneExtension;


            if (!$phone->save()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error storing phone'
                ], 500);
            }

            $phone = new ContactPhone;
            $phone->contactId = $contact->id;
            $phone->phone = request()->mobile;
            $phone->type = 'Mobile';

            if (!$phone->save()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error storing mobile'
                ], 500);
            }

            $phone = new ContactPhone;
            $phone->contactId = $contact->id;
            $phone->phone = request()->fax;
            $phone->type = 'Fax';

            if (!$phone->save()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error storing fax'
                ], 500);
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Contact updated successfully!'
        ], 200);
    }

    //delete
    public function destroy($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact does not exist!',
            ], 404);
        }


        if (!$contact->delete()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting contact!',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Contact deleted successfully!',
        ], 200);
    }
}
