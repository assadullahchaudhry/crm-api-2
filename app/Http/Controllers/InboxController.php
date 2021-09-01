<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatAttachment;
use App\Models\ChatConversation;
use App\Models\User;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function contacts()
    {
        $contacts = User::orderBy('firstName', 'asc')->where('id', '<>', auth()->user()->id)->where('isActive', true)->get();

        return response()->json([
            'status' => 'success',
            'contacts' => $contacts
        ], 200);
    }

    public function show($id)
    {

        $senderId = auth()->user()->id;
        $recipientId = $id;

        $chat = Chat::where('senderId', $senderId)->where('recipientId', $recipientId)->first();

        if (!$chat) {
            $chat = Chat::where('senderId',  $recipientId)->where('recipientId', $senderId)->first();
        }

        if (!$chat) {

            $id = getRandomId();

            $chat = new Chat();
            $chat->id = $id;
            $chat->senderId = $senderId;
            $chat->recipientid = $recipientId;

            if (!$chat->save()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error loading conversations'
                ], 500);
            }

            $chat = Chat::find($id);

            return response()->json(['status' => 'success', 'chat' => $chat], 200);
        }



        return response()->json(['status' => 'success', 'chat' => $chat], 200);
    }

    public function store()
    {
        if (!request()->chatId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error sending the message'
            ], 400);
        }

        $user = auth()->user();

        $chat = Chat::find(request()->chatId);

        if (!$chat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error loading conversations'
            ], 404);
        }

        if ($chat->senderId !=  $user->id && $chat->recipientId != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conversation does not exist'
            ], 404);
        }

        if (!request()->message and !request()->hasFile('attachments-0')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Message or attachment should be present'
            ], 400);
        }

        $conversation = new ChatConversation;
        $conversation->id = uuid();
        $conversation->chatId = $chat->id;
        $conversation->senderId = $user->id;
        $conversation->message = request()->message;

        if (!$conversation->save()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing conversation'
            ], 404);
        }

        if (request()->hasFile('attachments-0')) {
            $this->uploadAttachments(request(), $conversation->id, $chat->id);
        }

        $chat = Chat::find($chat->id);

        return response()->json(['status' => 'success', 'chat' => $chat], 200);
    }

    protected function uploadAttachments(Request $request, $conversationId, $chatId)
    {

        $destination = '/uploads/user/attachments/' . auth()->user()->id;

        foreach ($request->file() as $key => $file) {

            $file = uploadAttachment($file, $destination);

            if (!$file) {
                continue;
            }

            $attachment = new ChatAttachment;
            $attachment->conversationId = $conversationId;
            $attachment->chatId = $chatId;
            $attachment->senderId = auth()->user()->id;
            $attachment->name = $file['name'];
            $attachment->originalName = $file['originalName'];
            $attachment->type = $file['type'];
            $attachment->size = $file['size'];
            $attachment->url = $file['path'];
            $attachment->save();
        }
    }

    public function downloadAttachment($chatId, $attachmentId)
    {

        $chat = Chat::find($chatId);
        $user = auth()->user();

        if (!$chat or ($chat and $chat->recipientId != $user->id and $chat->senderId != $user->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error downloading attachment'
            ], 404);
        }

        $attachment = ChatAttachment::find($attachmentId);

        if (!$attachment or ($attachment and $attachment->chatId != $chat->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Attachment does not exist'
            ], 404);
        }


        $filePath = base_path('/public' . $attachment->url);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    }
}
