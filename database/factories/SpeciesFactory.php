<?php

namespace Database\Factories;

use App\Enums\Difficulty;
use App\Enums\Light;
use App\Enums\Watering;
use App\Models\Family;
use App\Models\Species;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Species>
 */
class SpeciesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $scientificName = Str::ucfirst(fake()->unique()->word()).' '.fake()->word();

        return [
            'family_id' => Family::factory(),
            'scientific_name' => $scientificName,
            'common_name' => Str::ucfirst(fake()->word()).' '.fake()->word(),
            'slug' => Str::slug($scientificName),
            'description' => fake()->sentence(),
            'light' => fake()->randomElement(Light::cases()),
            'watering' => fake()->randomElement(Watering::cases()),
            'difficulty' => fake()->randomElement(Difficulty::cases()),
            'toxic_to_pets' => fake()->boolean(),
            'care_notes' => fake()->paragraph(),
            'image' => null,
        ];
    }
}
