<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $users = User::all();
        $companies = Company::all();
        $statuses = ['completed', 'in process', 'over due', 'pending'];
        $dueDates = [\Carbon\Carbon::now()->addDays(5), \Carbon\Carbon::now()->addDays(6), \Carbon\Carbon::now()->addDays(7), \Carbon\Carbon::now()->addDays(9), \Carbon\Carbon::now()->addDays(15), \Carbon\Carbon::now()->addDays(21)];


        $user = $users[mt_rand(0, $users->count() - 1)];
        $company = $companies[mt_rand(0, $companies->count() - 1)];
        $status = $statuses[mt_rand(0, count($statuses) - 1)];
        $dueDate = $dueDates[mt_rand(0, count($dueDates) - 1)];

        return [
            'id' => getRandomId(),
            'assignedTo' => $user->id,
            'description' => $this->faker->realText(200, 2),
            'companyId' => $company->id,
            'startDate' =>  \Carbon\Carbon::now(),
            'dueDate' => $dueDate,
            'status' => $status
        ];
    }
}
