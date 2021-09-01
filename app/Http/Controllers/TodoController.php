<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // show all todo items
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

            $items = Todo::orderBy('created_at', 'desc')
                ->where('userId', auth()->user()->id)
                ->where('description', 'like', $query)
                ->orWhere('status', 'like', $query)
                ->skip($offset)
                ->take($limit)
                ->get();
        } else {
            $items = Todo::orderBy('created_at', 'desc')->where('userId', auth()->user()->id)->skip($offset)->take($limit)->get();
        }

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Todo::where('userId', auth()->user()->id)->count(),
                'items' => $items
            ],

        ], 200);
    }

    // store new todo list
    public function store(Request $request)
    {
        $this->validate(request(), [

            'description' => 'required',
            'status' => 'required',
        ]);

        $todo = new Todo;

        $todo->id = getRandomId();
        $todo->description = request()->description;
        $todo->status = request()->status;
        $todo->userId = auth()->user()->id;


        if (!$todo->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing todo'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => '',
            'id' => $todo->id
        ], 200);
    }

    // update specific todo item
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'status' => 'required',
        ]);

        $limit = 10;
        $offset = 0;

        $todo = Todo::find($id);

        if (!$todo or $todo->userId != auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'To Do item not found'
            ], 404);
        }

        $todo->status = request()->status;

        if (!$todo->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating To Do'
            ], 500);
        }

        $items = Todo::orderBy('created_at', 'desc')->where('userId', auth()->user()->id)->skip($offset)->take($limit)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'To Do updated successfully!',
            'items' => [
                'total' => Todo::where('userId', auth()->user()->id)->count(),
                'items' => $items
            ],
        ], 200);
    }

    // delete specific todo item
    public function destroy(Request $request, $id)
    {
        $todo = Todo::find($id);

        if (!$todo or $todo->userId != auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'To Do does not exist'
            ], 404);
        }

        if (!$todo->delete()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting To Do'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => ''
        ], 200);
    }
}
