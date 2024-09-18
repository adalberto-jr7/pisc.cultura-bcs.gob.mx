<?php

namespace Database\Seeders;

use App\Functions\FillTables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            'Teatro de la Ciudad',
            'Museo Regional de Antropología e Historia de B.C.S.',
            'Centro Cultural La Paz',
            'Museo de Arte de B.C.S.',
            'Galería de Arte Carlos Olachea B.',
            'Casa de la Cultura del Estado',
            'Archivo Histórico Pablo L. Martinez',
            'Escuela de Música del Estado',
            'Coordinación Técnica',
            'Dirección de Control Interno I.S.C.',
            'Coordinación Administrativa y Financiera',
            'Coordinación de Comunicación',
            'Coordinación Jurídica',
            'Coordinación Fomento Editorial',
            'Coordinación Estatal de Bibliotecas',
        ];

        foreach ($areas as $ac) {
            DB::table('areas')->insert([
                'name' => $ac,
            ]);
        }
    }
}
