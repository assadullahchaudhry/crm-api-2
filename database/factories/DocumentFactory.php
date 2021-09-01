<?php

namespace Database\Factories;


use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        $extensions = ['.jpg', '.png', '.svg', '.pdf', '.mov', '.docx', '.xml', '.html'];

        $extension = $extensions[mt_rand(0, (count($extensions) - 1))];
        $size = getFileSize(mt_rand(1000, 10000000));

        $user = User::where('email', 'superadmin@example.com')->first();

        return [
            'id' => uuid(),
            'ownerId' => $user->id,
            'originalName' => getRandomId() . '' . $extension,
            'name' => getRandomId() . '' . $extension,
            'size' => $size,
            'type' => str_replace('.', '', $extension),
            'url' => $this->faker->url
        ];
    }
}
