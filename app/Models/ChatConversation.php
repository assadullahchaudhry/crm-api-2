<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatConversation extends Model
{

    use HasFactory;

    protected $table = 'auc_chat_conversations';
    public $incrementing = false;

    protected $with = ['sender', 'attachments'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'senderId', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(ChatAttachment::class, 'conversationId', 'id');
    }
}
