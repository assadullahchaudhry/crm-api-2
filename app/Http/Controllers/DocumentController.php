<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
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

            $items = Document::orderBy('created_at', 'desc')
                ->where('originalName', 'like', $query)
                ->where('ownerId', auth()->user()->id)
                ->skip($offset)
                ->take($limit)
                ->get();
        } else {
            $items = Document::orderBy('name', 'asc')->where('ownerId', auth()->user()->id)->skip($offset)->take($limit)->get();
        }

        return response()->json([
            'status' => 'success',
            'items' => [
                'total' => Document::where('ownerId', auth()->user()->id)->count(),
                'items' => $items
            ],

        ], 200);
    }



    //get 
    public function show($id)
    {
        $document = Document::find($id);

        if (!$document and $document->ownerId != auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Document does not exist'
            ], 404);
        }

        $filePath = base_path('/public' . $document->url);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    }

    //create
    public function store(Request $request)
    {
        $this->validate(request(), [
            'document' => 'required|file'
        ]);
        $destination = '/uploads/user/docs/' . auth()->user()->id;

        $file = uploadFile(request(), 'document', $destination);

        if (!$file) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing document'
            ], 500);
        }

        $document = new Document;
        $document->id = uuid();
        $document->ownerId = auth()->user()->id;
        $document->name = $file['name'];
        $document->originalName = $file['originalName'];
        $document->type = $file['type'];
        $document->size = $file['size'];
        $document->url = $file['path'];

        if (!$document->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing document'
            ], 500);
        }
    }

    //delete 

    public function destroy($id)
    {
        $document = Document::find($id);

        if (!$document and $document->ownerId != auth()->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Document does not exist!',
            ], 404);
        }

        if (!$document->delete()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting document!',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Document deleted successfully!',
        ], 200);
    }
}
