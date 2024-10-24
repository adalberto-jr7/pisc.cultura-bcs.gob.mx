<?php

namespace Database\Seeders;

use App\Functions\FillTables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'En curso',
            'Concluido',
            'Pendiente',
        ];
        $ft = new FillTables();
        $ft->Fill($statuses, 'statuses');
    }
}
