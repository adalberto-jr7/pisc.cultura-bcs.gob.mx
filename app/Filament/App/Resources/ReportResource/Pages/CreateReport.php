<?php

namespace App\Filament\App\Resources\ReportResource\Pages;

use App\Filament\App\Resources\ReportResource;
use App\Imports\ActivitiesImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;
}
