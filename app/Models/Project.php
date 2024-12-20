<?php

namespace App\Models;

use App\Enums\MonthsEnum;
use App\Observers\ProjectObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ProjectObserver::class])]
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'code',
        'year',
        'area_id',
        'initial_month',
        'last_month',
        'completion_month'
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
