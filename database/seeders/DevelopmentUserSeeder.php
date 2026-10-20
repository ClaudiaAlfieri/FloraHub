<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DevelopmentUserSeeder extends Seeder
{
    /**
     * Create one user for each role, for local development only.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@florahub.test'],
            ['name' => 'Rui Mendes', 'password' => 'password'],
        );
        $admin->markEmailAsVerified();
        $admin->syncRoles('admin');

        // Exercício: criar o utilizador user@florahub.test
        $user=User::firstOrCreate(
            ['email'=>'user@florahub.test'],
            ['name'=>'Sofia Almeida','password'=>'password']
        );
        $user->markEmailAsVerified();
        $user->syncRoles('user');

    }
}
