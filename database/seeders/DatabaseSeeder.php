<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();
        $this->call([
            CategorySeeder::class,
            ActivityTypeSeeder::class,
            DisciplineSeeder::class,
            TypeSeeder::class,
            StatusSeeder::class,
            FinnancingSourceSeeder::class,
            AreaSeeder::class,
            ProjectSeeder::class,
        ]);
    }
}
