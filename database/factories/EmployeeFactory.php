<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Entity;
use App\Models\Stakeholder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'public_id' => fake()->word(),
            'is_leader_shop' => fake()->boolean(),
            'phone_number' => fake()->phoneNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'route_id' => Entity::factory(),
            'department_id' => Entity::factory(),
            'station_id' => Entity::factory(),
            'stakeholder_id' => Stakeholder::factory(),
        ];
    }
}
