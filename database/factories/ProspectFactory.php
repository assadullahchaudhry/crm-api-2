<?php

namespace Database\Factories;

use App\Models\Prospect;
use App\Models\Group;
use App\Models\Stage;
use App\Models\Action;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProspectFactory extends Factory
{
    protected $model = Prospect::class;

    public function definition(): array
    {
        $groups = Group::all();
        $actions = Action::all();
        $stages = Stage::all();
        $contacts = Contact::all();
        $priorities = ['High', 'Medium', 'Low'];
        $propbabilities = [10, 20, 30, 40, 50, 60, 70, 80, 19, 100];
        $closedForcasts = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $dealProfits = [10000, 20000, 30000, 4000, 25300, 345210, 9000, 100000, 32485];


        $group = $groups[mt_rand(0, ($groups->count() - 1))];
        $action = $actions[mt_rand(0, ($actions->count() - 1))];
        $stage = $stages[mt_rand(0, ($stages->count() - 1))];
        $contact = $contacts[mt_rand(0, ($contacts->count() - 1))];
        $priority = $priorities[mt_rand(0, (count($priorities) - 1))];
        $probability = $propbabilities[mt_rand(0, (count($propbabilities) - 1))];
        $closedForecasted = $closedForcasts[mt_rand(0, (count($closedForcasts) - 1))];
        $dealProfit = $dealProfits[mt_rand(0, (count($dealProfits) - 1))];

        return [
            'id' => getRandomId(),
            'name' => $this->faker->catchPhrase,
            'groupId' => $group->id,
            'priority' => $priority,
            'closeProbability' => $probability,
            'stageId' => $stage->id,
            'actionId' => $action->id,
            'closeForecasted' => $closedForecasted,
            'dealProfit' => $dealProfit,
            'locations' => $probability,
            'contactId' => $contact->id
        ];
    }
}
