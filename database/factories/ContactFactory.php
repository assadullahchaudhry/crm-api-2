<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\State;
use App\Models\Contact;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $industries = ['IT', 'Medical', 'Automobile'];

        $industry = $industries[mt_rand(0, count($industries) - 1)];


        $cities = City::where('country_code', 'US')->get();
        $city = $cities[mt_rand(0, $cities->count() - 1)];

        $state = State::find($city->state_id);
        $country = Country::find($city->country_id);



        return [
            'id' => getRandomId(),
            // 'firstName' => $this->faker->firstName,
            // 'lastName' => $this->faker->lastName,
            // 'email' => $this->faker->unique()->safeEmail,
            // 'phone' =>  $this->faker->tollFreePhoneNumber,
            // 'phoneExtension' => '888'
            'name' => $this->faker->catchPhrase,
            'group' => $this->faker->catchPhrase,
            'industry' => $industry,
            'contactType' => 'Customer',
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'officePhone' => $this->faker->tollFreePhoneNumber,
            'cell' => $this->faker->tollFreePhoneNumber,
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
            'ownerEmail'  => $this->faker->safeEmail,
            'ownerPhones' => json_encode([$this->faker->tollFreePhoneNumber, $this->faker->tollFreePhoneNumber,]),
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
