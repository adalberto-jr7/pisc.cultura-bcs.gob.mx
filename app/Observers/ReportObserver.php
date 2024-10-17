<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        $admin = User::where('role', '1')->get();
        $area = DB::table('areas')
            ->where('id', $report->area_id)
            ->value('name');

        Notification::make()
            ->title('Se a creado un nuevo reporte.')
            ->body(new HtmlString('El area: <strong>' . $area . '</strong>' . ' a publicado un nuevo reporte.'))
            ->actions([
                \Filament\Notifications\Actions\Action::make('Ver Reporte')
                    ->url(route('filament.administrador.resources.reports.view', $report->id))
                    ->button()
            ])
            ->sendToDatabase($admin);
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
