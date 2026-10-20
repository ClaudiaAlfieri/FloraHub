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
            // Exercício: acrescentar as restantes famílias
        ];

        foreach ($families as $name => $description) {
            Family::withTrashed()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description],
            );
        }
    }
}
