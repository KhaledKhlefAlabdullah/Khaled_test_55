<?php

namespace Database\Factories;

use App\Models\Disaster_report;
use App\Models\Employee;
use App\Models\Entity;
use App\Models\Natural_disaster;
use App\Models\Shipment;
use App\Models\Supplier;
use App\Models\Waste;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class Disaster_reportFactory extends Factory
{
    protected $model = Disaster_report::class;

    public function definition(): array
    {
        return [
            'is_safe' => fake()->boolean(),
            'impact_date' => Carbon::now(),
            'start_date' => Carbon::now(),
            'stop_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'natural_disaster_id' => Natural_disaster::factory(),
            'entity_id' => Entity::factory(),
            'shipment_id' => Shipment::factory(),
            'supplier_id' => Supplier::factory(),
            'employee_id' => Employee::factory(),
            'waste_id' => Waste::factory(),
        ];
    }
}
