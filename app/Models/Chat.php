<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'auc_chats';
    public $incrementing = false;

    protected $with = ['sender', 'recipient', 'conversations', 'attachments'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'senderId', 'id');
    }
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipientId', 'id');
    }

    public function conversations()
    {
        return $this->hasMany(ChatConversation::class, 'chatId', 'id')->orderBy('created_at', 'asc');
    }

    public function attachments()
    {
        return $this->hasMany(ChatAttachment::class, 'chatId', 'id');
    }
}
