<?php

namespace App\Filament\Resources\DailyRiddleResource\Pages;

use App\Filament\Resources\DailyRiddleResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDailyRiddles extends ManageRecords
{
    protected static string $resource = DailyRiddleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
