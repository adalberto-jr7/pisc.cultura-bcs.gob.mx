<?php

namespace App\Models;

use App\Enums\MonthsEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'code',
        'area_id',
    ];
    protected $casts = [
        'initial_month' => MonthsEnum::class,
        'last_month' => MonthsEnum::class,
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}