<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create(['role' => 1]);
        User::factory(1)->create();
        $this->call([
            CategorySeeder::class,
            ActivitySeeder::class,
            DisciplineSeeder::class,
            TypeSeeder::class,
            StatusSeeder::class,
            FinnancingSourceSeeder::class,
            AreaSeeder::class,
        ]);
    }
}
