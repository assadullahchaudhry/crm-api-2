<?php

namespace Database\Factories;


use App\Models\City;
use App\Models\Group;
use App\Models\GroupLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupLocationFactory extends Factory
{
    protected $model = GroupLocation::class;

    public function definition(): array
    {

        $groups = Group::get();
        $cities = City::where('country_code', 'US')->get();

        $group = $groups[mt_rand(0, $groups->count() - 1)];
        $city = $cities[mt_rand(0, $cities->count() - 1)];


        return [
            'groupId' => $group->id,
            'address' => $this->faker->address,
            'cityId' => $city->id,
            'stateId' => $city->state_id,
            'countryId' => $city->country_id,
            'postalCode' => mt_rand(100, 1000)

        ];
    }
}
