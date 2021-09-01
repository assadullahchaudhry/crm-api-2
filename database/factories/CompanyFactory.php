<?php

namespace Database\Factories;


use App\Models\City;
use App\Models\State;
use App\Models\Company;
use App\Models\Country;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        $cities = City::where('country_code', 'US')->get();
        $city = $cities[mt_rand(0, $cities->count() - 1)];

        $state = State::find($city->state_id);
        $country = Country::find($city->country_id);



        return [
            'id' => getRandomId(),
            'name' => $this->faker->catchPhrase,
            'group' => $this->faker->catchPhrase,
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'omEmail' => $this->faker->safeEmail,
            'officePhone' => $this->faker->tollFreePhoneNumber,
            'addressLine1' => $this->faker->address,
            'addressLine2' => $this->faker->address,
            'city' => $city->name,
            'state' => $state ? $state->name : null,
            // 'postalCode',
            'countryCode' => $country->iso2,
            'regionalFirstName'  => $this->faker->firstName,
            'regionalLastName'  => $this->faker->lastName,
            'regionalEmail'  => $this->faker->safeEmail,
            'regionalCell' => $this->faker->tollFreePhoneNumber,
            'doFirstName'  => $this->faker->firstName,
            'doLastName'  => $this->faker->lastName,
            'doEmail'  => $this->faker->safeEmail,
            'doCell' => $this->faker->tollFreePhoneNumber,
            // 'billingContacts',
            'billingEmail'  => $this->faker->safeEmail,
            'billingPhone' => $this->faker->tollFreePhoneNumber,
            'ownerName' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'itContactFirstName'  => $this->faker->firstName,
            'itContactLastName'  => $this->faker->lastName,
            'itSupportPhone' => $this->faker->tollFreePhoneNumber,
            'itSupportEmail'  => $this->faker->safeEmail,
            'preferredSuppliesShippingService' => $this->faker->catchPhrase,
            'shipstationUsername' => $this->faker->catchPhrase,
            'fullAddress' => $this->faker->address,
            // 'notes',

        ];
    }
}
