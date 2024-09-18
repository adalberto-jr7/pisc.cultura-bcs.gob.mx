<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_name',
        'category_id',
        'activity_goal',
        'description',
        'activity_type_id',
        'discipline_id',
        'author_name',
        'initial_date',
        'end_date',
        'name_space_held',
        'locality',
        'municipality',
        'total',
        'women_total',
        'men_total',
        'children_girls',
        'children_boys',
        'youth_women',
        'youth_men',
        'adult_women',
        'adult_men',
        'senior_women',
        'senior_men',
        'social_women',
        'social_childrens',
        'social_seniors',
        'social_indigenous',
        'social_disabled',
        'social_migrants',
        'social_afrodescendants',
        'social_incarcerated',
        'social_lgbtttiq',
        'finnancing_source_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function activityType(): BelongsTo
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class);
    }
}
