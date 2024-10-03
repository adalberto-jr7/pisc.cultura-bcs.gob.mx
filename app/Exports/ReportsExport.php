<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Report::with('activities')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Project Description',
            'Area Name',
            'User Name',
            'Status Name',
            'Activity Name',
            'Category',
            'Activity Goal',
            'Description',
            'Activity Type',
            'Discipline',
            'Author Name',
            'Initial Date',
            'End Date',
            'Name Space Held',
            'Locality',
            'Municipality',
            'Total',
            'Women Total',
            'Men Total',
            'Children Girls',
            'Children Boys',
            'Youth Women',
            'Youth Men',
            'Adult Women',
            'Adult Men',
            'Senior Women',
            'Senior Men',
            'Social Women',
            'Social Childrens',
            'Social Seniors',
            'Social Indigenous',
            'Social Disabled',
            'Social Migrants',
            'Social Afrodescendants',
            'Social Incarcerated',
            'Social LGBTTTIQ',
            'Finnancing Source',
            'Area'
        ];
    }

    public function map($report): array
    {
        $mappedActivities = [];

        foreach ($report->activities as $activity) {
            $mappedActivities[] = [
                $report->id,
                $report->project->description,
                $report->area->name,
                $report->user->name,
                $report->status->name,
                $activity->id,
                $activity->activity_name,
                $activity->category->name,
                $activity->activity_goal,
                $activity->description,
                $activity->activityType->name,
                $activity->discipline->name,
                $activity->author_name,
                $activity->initial_date,
                $activity->end_date,
                $activity->name_space_held,
                $activity->locality,
                $activity->municipality,
                $activity->total,
                $activity->women_total,
                $activity->men_total,
                $activity->children_girls,
                $activity->children_boys,
                $activity->youth_women,
                $activity->youth_men,
                $activity->adult_women,
                $activity->adult_men,
                $activity->senior_women,
                $activity->senior_men,
                $activity->social_women,
                $activity->social_childrens,
                $activity->social_seniors,
                $activity->social_indigenous,
                $activity->social_disabled,
                $activity->social_migrants,
                $activity->social_afrodescendants,
                $activity->social_incarcerated,
                $activity->social_lgbtttiq,
                $activity->finnancingSource->name ?? '',
                $activity->area->name
            ];
        }
        return $mappedActivities;
    }
}
