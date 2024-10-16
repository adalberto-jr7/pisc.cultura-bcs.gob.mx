<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\User;
use Filament\Notifications\Notification;

class ProjectObserver
{
    public function created(Project $project): void
    {
        $area_id = $project->area_id;
        $user = User::where('area_id', $area_id)->get();
        Notification::make()
            ->title('Proyecto Asignado')
            ->body('Se te a asignado el proyecto: ' . $project->description)
            ->sendToDatabase($user);
    }
}
