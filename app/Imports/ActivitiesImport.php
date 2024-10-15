<?php

namespace App\Imports;

use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Category;
use App\Models\Discipline;
use App\Models\FinnancingSource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ActivitiesImport implements WithMappedCells, ToModel, WithStartRow
{
    public function mapping(): array
    {
        return [
            'activity_name' => 'A16',
            'category_id' => 'B16',
            'activity_goal' => 'C16',
            'description' => 'D16',
            'activity_type_id' => 'E16',
            'discipline_id' => 'F16',
            'author_name' => 'G16',
            'initial_date' => 'H16',
            'end_date' => 'H16',
            'name_space_held' => 'I16',
            'locality' => 'J16',
            'municipality' => 'K16',
            'total' => 'L16',
            'women_total' => 'M16',
            'men_total' => 'N16',
            'children_girls' => 'O16',
            'children_boys' => 'P16',
            'youth_women' => 'Q16',
            'youth_men' => 'R16',
            'adult_women' => 'S16',
            'adult_men' => 'T16',
            'senior_women' => 'U16',
            'senior_men' => 'V16',
            'social_women' => 'W16',
            'social_childrens' => 'X16',
            'social_seniors' => 'Y16',
            'social_indigenous' => 'Z16',
            'social_disabled' => 'AA16',
            'social_migrants' => 'AB16',
            'social_afrodescendants' => 'AC16',
            'social_incarcerated' => 'AD16',
            'social_lgbtttiq' => 'AE16',
            'finnancing_source_id' => 'AF16',
        ];
    }

    public function startRow(): int
    {
        return 16;
    }

    public function model(array $row)
    {
        $category = Category::where('name', $row['category_id'])->firstOrFail();
        $activity_type = ActivityType::where('name', $row['activity_type_id'])->firstOrFail();
        $discipline = Discipline::where('name', $row['discipline_id'])->firstOrFail();
        $finnaning_source = FinnancingSource::where('name', $row['finnancing_source_id'])->firstOrFail();

        if (empty(array_filter($row))) {
            return null;
        }

        return new Activity([
            'activity_name' => $row['activity_name'],
            'category_id' => $category->id,
            'activity_goal' => $row['activity_goal'],
            'description' => $row['description'],
            'activity_type_id' => $activity_type->id,
            'discipline_id' => $discipline->id,
            'author_name' => $row['author_name'],
            //'initial_date' => $row['initial_date'],
            //'end_date' => $row['end_date'],
            'name_space_held' => $row['name_space_held'],
            'locality' => $row['locality'],
            'municipality' => $row['municipality'],
            'total' => $row['total'],
            'women_total' => $row['women_total'],
            'men_total' => $row['men_total'],
            'children_girls' => $row['children_girls'],
            'children_boys' => $row['children_boys'],
            'youth_women' => $row['youth_women'],
            'youth_men' => $row['youth_men'],
            'adult_women' => $row['adult_women'],
            'adult_men' => $row['adult_men'],
            'senior_women' => $row['senior_women'],
            'senior_men' => $row['senior_men'],
            'social_women' => $row['social_women'],
            'social_childrens' => $row['social_childrens'],
            'social_seniors' => $row['social_seniors'],
            'social_indigenous' => $row['social_indigenous'],
            'social_disabled' => $row['social_disabled'],
            'social_migrants' => $row['social_migrants'],
            'social_afrodescendants' => $row['social_afrodescendants'],
            'social_incarcerated' => $row['social_incarcerated'],
            'social_lgbtttiq' => $row['social_lgbtttiq'],
            'finnancing_source_id' => $finnaning_source->id,
        ]);
    }
}
