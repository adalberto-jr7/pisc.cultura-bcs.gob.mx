<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $description = "Actualización de catálogos y revisión de fichas";
        DB::table('projects')->insert([
            'description' => $description,
            'code' => Str::slug($description),
            'area_id' => 7,
            'initial_month' => 'Enero',
            'last_month' => 'Diciembre',
            'year' => 2023
        ]);
    }
}
