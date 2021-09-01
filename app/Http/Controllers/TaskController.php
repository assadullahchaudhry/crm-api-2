<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Company;
use App\Models\Affiliate;
use Illuminate\Http\Request;

class TaskController extends Controller
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

            $items = Task::orderBy('created_at', 'desc')
                ->where('description', 'like', $query)
                ->orWhere('status', 'like', $query)
                ->skip($offset)
                ->take($limit)
                ->get();
        } else {
            $items = Task::orderBy('created_at', 'desc')->skip($offset)->take($limit)->get();
        }

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Task::count(),
                'items' => $items
            ],

        ], 200);
    }

    public function all()
    {

        $items = Task::orderBy('created_at', 'desc')->get();

        $tasks = [];

        if ($items->count()) {
            foreach ($items as $item) {

                $bg = null;

                if ($item->status == 'completed') {
                    $bg = '#1EB56A';
                } else if ($item->status == 'over due') {
                    $bg = '#de4d55';
                } else if ($item->status == 'in process') {
                    $bg = '#FF9519';
                } else if ($item->status == 'pending') {
                    $bg = '#B9B9B9';
                }


                $tasks[] = [
                    'start' => $item->startDate,
                    'end' => $item->dueDate,
                    'title' => substr($item->description, 0, 20) . '...',
                    'backgroundColor' => $bg,
                    'borderColor' => $bg
                    //'title' => '1234'
                    //'title' => $item->description
                ];
            }
        }


        return response()->json([
            'status' => 'success',
            'items' => $tasks

        ], 200);
    }

    public function refs()
    {
        $companies = Company::select('id', 'name')->orderBy('name', 'asc')->get();
        $users = User::select('id', 'firstName', 'lastName', 'avatar')->orderBy('firstName', 'asc')->get();


        return response()->json([
            'status' => 'success',
            'companies' => $companies,
            'users' => $users
        ], 200);
    }

    //get one user
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task does not exist'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'item' => $task,
            'total' => Task::count()
        ], 200);
    }

    //create
    public function store(Request $request)
    {
        $this->validate(request(), [
            'description' => 'required|string',
            'companyId' => 'nullable',
            'startDate' => 'required',
            'dueDate' => 'required',
            'assignedTo' => 'required'
        ]);

        $user = User::find(request()->assignedTo);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not exist'
            ], 404);
        }


        $task = new Task;
        $task->id = getRandomId();
        $task->description = request()->description;

        if (request()->companyId) {

            $company = Company::find(request()->companyId);

            if (!$company) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Company does not exist'
                ], 404);
            }

            $task->companyId = request()->companyId;
        }

        $task->assignedTo = request()->assignedTo;
        $task->startDate = \Carbon\Carbon::parse(request()->startDate);
        $task->dueDate = \Carbon\Carbon::parse(request()->dueDate);



        if (!$task->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing task'
            ], 500);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully!'
        ], 200);
    }

    //update
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'description' => 'required|string',
            'companyId' => 'nullable',
            'startDate' => 'required',
            'dueDate' => 'required',
            'assignedTo' => 'required',
            'status' => 'required'
        ]);

        $user = User::find(request()->assignedTo);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not exist'
            ], 404);
        }


        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task does not exist'
            ], 404);
        }

        $task->description = request()->description;

        if (request()->companyId) {

            $company = Company::find(request()->companyId);

            if (!$company) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Company does not exist'
                ], 404);
            }

            $task->companyId = request()->companyId;
        }

        $task->status = request()->status;
        $task->assignedTo = request()->assignedTo;
        $task->startDate = \Carbon\Carbon::parse(request()->startDate);
        $task->dueDate = \Carbon\Carbon::parse(request()->dueDate);



        if (!$task->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating task'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully!'
        ], 200);
    }

    //delete 
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task does not exist!',
            ], 404);
        }

        if (!$task->delete()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting task!',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully!',
        ], 200);
    }
}
