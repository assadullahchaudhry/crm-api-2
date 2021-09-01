<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {

        return [
            'id' => getRandomId(),
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('123456789'),
            'roleId' => $this->faker->randomElement([1, 2, 3]),
            // 'phone' =>  $this->faker->tollFreePhoneNumber,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'isActive' => true
        ];
    }
}
