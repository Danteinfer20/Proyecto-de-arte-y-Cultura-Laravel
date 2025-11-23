<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Location;
use App\Models\PerformingArt;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'location_id' => Location::factory(), // Relación con Location
            'performing_art_id' => PerformingArt::factory(), // Relación con PerformingArt
        ];
    }
}
