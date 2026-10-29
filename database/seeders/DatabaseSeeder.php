<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            FamilySeeder::class,
            SpeciesSeeder::class,
        ]);

        if (app()->isLocal()) {
            $this->call(DevelopmentUserSeeder::class);
        }
    }
}
