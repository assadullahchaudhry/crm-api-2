<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Stage;
use App\Models\Action;
use App\Models\Contact;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProspectController extends Controller
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

            $items = Prospect::orderBy('name', 'asc')
                ->where('name', 'like', $query)
                ->orWhere('priority', 'like', $query)
                ->orWhere('closeProbability', 'like', $query)
                ->orWhere('closeForecasted', 'like', $query)
                ->orWhere('dealProfit', 'like', $query)
                ->orWhere('locations', 'like', $query)
                ->orWhere('entityName', 'like', $query)
                ->orWhere('appNumber', 'like', $query)
                ->orWhere('creditApplication', 'like', $query)
                ->orWhere('leadSource', 'like', $query)
                ->orWhere('industry', 'like', $query)
                ->orWhere('notes', 'like', $query)
                ->skip($offset)
                ->take($limit)
                ->get();
        } else {
            $items = Prospect::orderBy('name', 'asc')->skip($offset)->take($limit)->get();
        }

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Prospect::count(),
                'items' => $items
            ],

        ], 200);
    }

    public function refs()
    {
        $contacts = Contact::select('id', 'firstName', 'lastName')->orderBy('firstName', 'asc')->get();
        $groups = Group::select('id', 'name')->orderBy('name', 'asc')->get();
        $actions = Action::select('id', 'name')->orderBy('name', 'asc')->get();
        $stages = Stage::select('id', 'name')->orderBy('name', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'contacts' => $contacts,
            'groups' => $groups,
            'actions' => $actions,
            'stages' => $stages
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $this->validate(request(), [
            'name'              => 'required|string',
            'groupId'           => 'required',
            'priority'          => 'required',
            'closeProbability'  => 'nullable',
            'stage'           => 'required',
            'action'          => 'required',
            'closeForecasted'  => 'required',
            'dealProfit'        => 'required|numeric',
            'dealMatrixLink'    => 'nullable',
            'locations'         => 'required|numeric',
            'entityName'        => 'nullable',
            'appNumber'         => 'nullable',
            'creditApplication' => 'nullable',
            'leadSource'        => 'nullable',
            'industry'          => 'nullable',
            'notes'             => 'required',
            'contactId'         => 'required'
        ]);

        $group = Group::find(request()->groupId);

        if (!$group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Group does not exist.'
            ], 404);
        }

        $stage = Stage::where('name', request()->stage)->first();

        if (!$stage) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stage does not exist.'
            ], 404);
        }

        $action = Action::where('name', request()->action)->first();

        if (!$stage) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stage does not exist.'
            ], 404);
        }

        $contact = Contact::find(request()->contactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact does not exist.'
            ], 404);
        }


        // store
        $prospect = new Prospect;
        $prospect->id                = getRandomId();
        $prospect->name              = request()->name;
        $prospect->groupId           = $group->id;
        $prospect->priority          = request()->priority;
        $prospect->closeProbability  = request()->closeProbability;
        $prospect->stageId           = $stage->id;
        $prospect->actionId          = $action->id;
        $prospect->closeForecasted  = request()->closeForecasted;
        $prospect->dealProfit        = request()->dealProfit;
        $prospect->dealMatrixLink    = request()->dealMatrixLink;
        $prospect->locations         = request()->locations;
        $prospect->entityName        = request()->entityName;
        $prospect->appNumber         = request()->appNumber;
        $prospect->creditApplication = request()->creditApplication;
        $prospect->leadSource        = request()->leadSource;
        $prospect->industry          = request()->industry;
        $prospect->notes             = request()->notes;
        $prospect->contactId         = $contact->id;

        if (!$prospect->save()) {
            return response()->json(['status' => 'error', 'message' => 'Error creating prospect'], 500);
        }


        return response()->json(['status' => 'success', 'message' => 'Prospect created successfully!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
        $prospect = Prospect::find($id);

        if (!$prospect) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prospect does not exist'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'item' => $prospect,
            'total' => Prospect::count()
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate
        $this->validate(request(), [
            'name'              => 'required|string',
            'groupId'           => 'required',
            'priority'          => 'required',
            'closeProbability'  => 'nullable',
            'stage'           => 'required',
            'action'          => 'required',
            'closeForecasted'  => 'required',
            'dealProfit'        => 'required|numeric',
            'dealMatrixLink'    => 'nullable',
            'locations'         => 'required|numeric',
            'entityName'        => 'nullable',
            'appNumber'         => 'nullable',
            'creditApplication' => 'nullable',
            'leadSource'        => 'nullable',
            'industry'          => 'nullable',
            'notes'             => 'required',
            'contactId'         => 'required'
        ]);

        $prospect = Prospect::find($id);
        if (!$prospect) {
            return response()->json([
                'status' => 'error',
                'message' => 'Prospect does not exist.'
            ], 404);
        }


        $group = Group::find(request()->groupId);

        if (!$group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Group does not exist.'
            ], 404);
        }

        $stage = Stage::where('name', request()->stage)->first();

        if (!$stage) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stage does not exist.'
            ], 404);
        }

        $action = Action::where('name', request()->action)->first();

        if (!$stage) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stage does not exist.'
            ], 404);
        }

        $contact = Contact::find(request()->contactId);

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact does not exist.'
            ], 404);
        }

        $prospect->name              = request()->name;
        $prospect->groupId           = $group->id;
        $prospect->priority          = request()->priority;
        $prospect->closeProbability  = request()->closeProbability;
        $prospect->stageId           = $stage->id;
        $prospect->actionId          = $action->id;
        $prospect->closeForecasted  = request()->closeForecasted;
        $prospect->dealProfit        = request()->dealProfit;
        $prospect->dealMatrixLink    = request()->dealMatrixLink;
        $prospect->locations         = request()->locations;
        $prospect->entityName        = request()->entityName;
        $prospect->appNumber         = request()->appNumber;
        $prospect->creditApplication = request()->creditApplication;
        $prospect->leadSource        = request()->leadSource;
        $prospect->industry          = request()->industry;
        $prospect->notes             = request()->notes;
        $prospect->contactId         = $contact->id;

        if (!$prospect->save()) {
            return response()->json(['status' => 'error', 'message' => 'Error updating prospect'], 500);
        }


        return response()->json(['status' => 'success', 'message' => 'Prospect updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $prospect = Prospect::find($id);

        if (!$prospect) {
            return response()->json(['status' => 'error', 'message' => 'Prospect does not exist'], 404);
        }

        if ($prospect->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Prospect deleted successfully'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Error deleting prospect'], 500);
    }
}
