<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disciplines = [
            'Artes visuales',
            'Artes visuales',
            'Culturas populares',
            'Danza',
            'Literatura',
            'Memorias históricas',
            'Música',
            'Teatro',
            'Multidisciplinaria',
            'Otra',
        ];
        foreach($disciplines as $d)
        {
            DB::table('disciplines')->insert([
                'name' => $d
            ]);
        }
    }
}
