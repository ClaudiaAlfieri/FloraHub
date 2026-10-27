<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FamilySeeder extends Seeder
{
    /**
     * Seed the botanical families.
     */
    public function run(): void
    {
        $families = [
            'Araceae' => 'Família das aráceas, que inclui a Monstera, o Philodendron e o Anthurium.',
            'Cactaceae' => 'Plantas suculentas adaptadas a climas áridos, geralmente com espinhos.',
            'Rosaceae' => 'Inclui a roseira, a macieira, a pereira e o morangueiro.',
            'Asparagaceae' => 'Inclui a Sansevieria, a Dracaena e o espargo.',
            'Crassulaceae' => 'Suculentas com folhas carnudas, como a Crassula e o Echeveria.',
            'Lamiaceae' => 'Plantas aromáticas, como a hortelã, o alecrim e o manjericão.',
            'Marantaceae' => 'Plantas de folhagem decorativa, como a Calathea e a Maranta.',
            'Moraceae' => 'Inclui a figueira, o Ficus e a amoreira.',
            'Orchidaceae' => 'Uma das maiores famílias de plantas com flor: as orquídeas.',
            'Solanaceae' => 'Inclui o tomateiro, a batateira e o pimenteiro.',
        ];

        foreach ($families as $name => $description) {
            Family::withTrashed()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description],
            );
        }
    }
}
