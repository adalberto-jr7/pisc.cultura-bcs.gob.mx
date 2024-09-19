<?php

namespace Database\Seeders;

use App\Functions\FillTables;
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
            'Culturas populares',
            'Danza',
            'Literatura',
            'Memorias históricas',
            'Música',
            'Teatro',
            'Multidisciplinaria',
            'Otra',
        ];
        $ft = new FillTables();
        $ft->Fill($disciplines, 'disciplines');
    }
}
