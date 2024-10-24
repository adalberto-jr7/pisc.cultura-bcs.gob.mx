<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class ActivityObserver
{
    /**
     * Handle the Activity "created" event.
     */
    public function created(Activity $activity): void {}

    /**
     * Handle the Activity "updated" event.
     */
    public function updated(Activity $activity): void
    {
        DB::table('reports')
            ->where('id', $activity->report_id)
            ->update(['updated_at' => $activity->updated_at]);
    }

    /**
     * Handle the Activity "deleted" event.
     */
    public function deleted(Activity $activity): void
    {
        //
    }

    /**
     * Handle the Activity "restored" event.
     */
    public function restored(Activity $activity): void
    {
        //
    }

    /**
     * Handle the Activity "force deleted" event.
     */
    public function forceDeleted(Activity $activity): void
    {
        //
    }
}
