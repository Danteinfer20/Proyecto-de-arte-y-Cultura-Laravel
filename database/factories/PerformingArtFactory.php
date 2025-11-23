<?php

namespace Database\Factories;

use App\Models\PerformingArt;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerformingArtFactory extends Factory
{
    // El modelo asociado
    protected $model = PerformingArt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $artTypes = ['circus', 'theater', 'dance', 'performance', 'magic'];
        $audiences = ['children', 'adults', 'all'];

        return [
            'name' => $this->faker->unique()->sentence(3), // nombre del espectáculo
            'art_type' => $this->faker->randomElement($artTypes), // tipo de arte escénico
            'duration_minutes' => $this->faker->numberBetween(30, 180), // duración en minutos
            'artistic_director' => $this->faker->name(), // director artístico
            'company' => $this->faker->company(), // compañía/productora
            'genre' => $this->faker->word(), // género
            'target_audience' => $this->faker->randomElement($audiences), // público objetivo
            'technical_requirements' => $this->faker->sentence(), // requerimientos técnicos
            'cast_members' => $this->faker->words(3), // reparto como array
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
