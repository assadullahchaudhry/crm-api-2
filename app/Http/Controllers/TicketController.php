<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    // index ticket
    public function index()
    {
        $tickets = Ticket::paginate(10);
        if ($tickets) {
            return response()->json([
                'status' => 'success',
                'response' => $tickets,
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'response' => 'Record not found',
        ], 404);
    }

    // store ticket
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companyId' => 'required|exists:auc_companies,id',
            'subject' => 'required',
            'description' => 'required',
            'createdBy' => 'nullable|exists:auc_users,id',
            'assignedTo' => 'nullable|exists:auc_users,id',
            'priority' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $ticket = Ticket::create([
            'id' => getRandomId(),
            'companyId' => $request->companyId,
            'subject' => $request->subject,
            'description' => $request->description,
            'createdBy' => $request->createdBy,
            'assignedTo' => $request->assignedTo,
            'priority' => $request->priority,
        ]);

        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error adding record'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Record added',
        ], 200);
    }

    // show ticket
    public function show($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            return response()->json([
                'status' => 'success',
                'response' => $ticket,
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'response' => 'Record not found',
        ], 404);
    }

    // update ticket
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $validator = Validator::make($request->all(), [
                'companyId' => 'required|exists:auc_companies,id',
                'subject' => 'required',
                'description' => 'required',
                'createdBy' => 'nullable|exists:auc_users,id',
                'assignedTo' => 'nullable|exists:auc_users,id',
                'priority' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()->all()
                ], 422);
            }

            $update = $ticket->update([
                'companyId' => $request->companyId,
                'subject'   => $request->subject,
                'description' => $request->description,
                'status'    => $request->status,
                'createdBy' => $request->createdBy,
                'assignedTo' => $request->assignedTo,
                'priority'   => $request->priority,
            ]);
            if ($update) {
                return response()->json([
                    'status' => 'success',
                    'response' => 'Recored updated',
                ], 200);
            }
            return response()->json([
                'status' => 'error',
                'response' => 'Error updating record',
            ], 500);
        }
        return response()->json([
            'status' => 'error',
            'response' => 'Record not found',
        ], 404);
    }


    // delete ticket
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'response' => 'Record not found',
            ], 404);
        }
        if (!$ticket->delete()) {
            return response()->json([
                'status' => 'error',
                'response' => 'Error deleting record',
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'response' => 'Record deleted',
        ], 200);
    }
}
