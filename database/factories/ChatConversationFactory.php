<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\ChatConversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatConversationFactory extends Factory
{
    protected $model = ChatConversation::class;

    public function definition(): array
    {
        $user = User::where('email', 'superadmin@example.com')->first();

        $chats = Chat::where('senderId', $user->id)->get();

        $chat = $chats[mt_rand(0, ($chats->count() - 1))];

        $senders = [$chat->senderId, $chat->recipientId];
        $senderId =  $senders[mt_rand(0, (count($senders) - 1))];


        return [
            'id' => uuid(),
            'senderId' => $senderId,
            'message' => $this->faker->catchPhrase,
            'chatId' => $chat->id,
            'seen' => false
        ];
    }
}
