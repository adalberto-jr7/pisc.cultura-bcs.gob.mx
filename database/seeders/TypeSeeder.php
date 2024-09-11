<?php

namespace Database\Seeders;

use App\Functions\FillTables;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Remodelación',
            'Rehabilitación',
            'Mantenimiento',
            'Equipamiento',
            'Conservación',
            'Digitalización y conservación de archivos y acervos históricos, artísticos y culturales',
            'Equipamiento de espacios culturales y/o grupos artísticos',
            'Murales',
            'Desarrollo de herramientas tecnológicas (pag. Web y plataformas que brinden servicios culturales)',
            'Ediciones y publicaciones',
            'Otros',
        ];
        $ft = new FillTables();
        $ft->Fill($types, 'types');
    }
}
