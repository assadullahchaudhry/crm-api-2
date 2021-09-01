<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    protected $model = Chat::class;

    public function definition(): array
    {

        $user = User::where('email', 'superadmin@example.com')->first();

        $recipients = User::where('id', '<>', $user->id)->get();

        $recipient = $recipients[mt_rand(0, ($recipients->count() - 1))];


        return [
            'id' => uuid(),
            'senderId' => $user->id,
            'recipientId' => $recipient->id,
        ];
    }
}
