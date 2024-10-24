<?php

namespace App\Functions;

use Illuminate\Support\Facades\DB;

class FillTables
{
    public function Fill($data, $table): void
    {
        foreach ($data as $d) {
            DB::table($table)->insert(
                ['name' => $d]
            );
        }
    }
}
