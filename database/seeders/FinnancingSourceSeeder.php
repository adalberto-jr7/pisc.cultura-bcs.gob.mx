<?php

namespace Database\Seeders;

use App\Functions\FillTables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinnancingSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $finnancing_sources = [
            'Federal',
            'Estatal',
            'Recurso propio',
        ];
        $ft = new FillTables();
        $ft->Fill($finnancing_sources, 'finnancing_sources');
    }
}
