<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\ChatConversation;
use App\Models\ChatAttachment;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class ChatController extends Controller
{
    //
    function initiate(Request $request)
    {

        $rules = array(
            'recipientId'  => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        //validation 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $senderId = Auth::user()->id;
        $recipientId = $request->recipientId;

        //check if thread already in table
        $chat = Chat::where('senderId', '=', $senderId)->where('recipientId', '=', $recipientId)->first();

        if (!$chat) {
            $chat = Chat::where('senderId', '=', $recipientId)->where('recipientId', '=', $senderId)->first();
        }

        //if no thread then create new one
        if (!$chat) {

            $chat = new Chat();
            $chat->id = getRandomId();
            $chat->senderId = $senderId;
            $chat->recipientid = $recipientId;

            if (!$chat->save()) {
                return response()->json(
                    [
                        'message' => 'Error Creating Chat Thread'
                    ],
                    500
                );
            }
        }

        return response()->json(['status' => 'success', 'chat' => $chat], 200);
    }

    function conversations(Request $request)
    {

        $rules = array(
            'chatId'  => 'required',
            'recipientId' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        //validation 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $chatId = $request->chatId;
        $senderId = Auth::user()->id;
        $recipientId = $request->recipientId;

        //check if thread already in table
        $chat = Chat::where('senderId', '=', $senderId)
            ->where('recipientId', '=', $recipientId)
            ->where('id', $chatId)->first();

        if (!$chat) {
            //check if thread already in table
            $chat = Chat::where('senderId', '=', $recipientId)
                ->where('recipientId', '=', $senderId)
                ->where('id', $chatId)->first();
        }

        if (!$chat) {
            return response()->json(
                [
                    'message' => 'Chat not Found'
                ],
                404
            );
        }

        //save chat conversation
        $conversation = new ChatConversation();
        $conversation->id = uuid();
        $conversation->chatId = $chatId;
        $conversation->senderId = $senderId;
        $conversation->message = $request->message;
        if (!$conversation->save()) {
            return response()->json(
                [
                    'message' => 'Error Creating Chat Conversation'
                ],
                500
            );
        }
        //if file sent the upload and save to the table
        if ($request->hasFile('attachments')) {
            $chatId = $conversation->id;
            $attachment = $this->attachFiles($request, $chatId);
            $total = count($request->file('attachments'));
            $failed = $attachment['filesCount'];
            if ($total == $failed) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Error storing attachments',
                ], 500);
            }

            $message = $failed == 0 ? 'All attachments Stored Successfully' :
                "{$failed} of {$total} attachments failed to store";

            return response()->json([
                'status' => 'success',
                'message' => $message,
            ], 200);
        }

        return true;
    }

    function attachFiles($request, $chatId)
    {

        $files = $request->file('attachments');

        if (count($files) > 1) {
            echo 'coming';
            $filesCount = count($files);
            foreach ($files as $file) {

                $name = $file->getClientOriginalName();
                $type = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $localpath = public_path("uploads/{$name}");
                $url = "/uploads/{$name}";

                $uploadFile = $file->move(public_path('/uploads'), $name);
                if (!file_exists($localpath)) {
                    $filesCount--;
                    continue;
                }
                $attachment = new ChatAttachment();
                $attachment->chatId = $chatId;
                $attachment->name = $name;
                $attachment->type = $type;
                $attachment->size = $size;
                $attachment->localpath = $localpath;
                $attachment->url = $url;
                if ($attachment->save()) {
                    $filesCount--;
                }
            }

            return ['filesCount' => $filesCount];
        } else {
            $file = $files[0];
            $name = $file->getClientOriginalName();
            $type = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $localpath = public_path("uploads/{$name}");
            $url = "/uploads/{$name}";

            $uploadFile = $file->move(public_path('/uploads'), $name);

            if (!file_exists($localpath)) {
                return ['filesCount' => 0];
            }

            $attachment = new ChatAttachment();
            $attachment->chatId = $chatId;
            $attachment->name = $name;
            $attachment->type = $type;
            $attachment->size = $size;
            $attachment->localpath = $localpath;
            $attachment->url = $url;
            if (!$attachment->save()) {
                return ['filesCount' => 1];
            }

            return ['filesCount' => 0];
        }
    }
}
