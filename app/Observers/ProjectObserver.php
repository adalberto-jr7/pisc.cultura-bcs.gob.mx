<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;

class ProjectObserver
{
    public function created(Project $project): void
    {
        $area_id = $project->area_id;
        $user = User::where('area_id', $area_id)->get();
        Notification::make()
            ->title('Proyecto Asignado')
            ->body(new HtmlString('Se te a asignado el proyecto: <p><strong>' . $project->description . '</strong><br />' . Auth::user()->name . '</p>'))
            ->sendToDatabase($user);
    }
}
