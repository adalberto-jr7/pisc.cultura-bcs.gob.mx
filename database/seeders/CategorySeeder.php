<?php

namespace Database\Seeders;

use App\Functions\FillTables;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $ft = new FillTables();
    }
}
$ft->Fill(['Promoción', 'Formación'], 'categories');