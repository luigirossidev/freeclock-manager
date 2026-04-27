<?php

namespace App\Filament\Resources\RiddleResource\Pages;

use App\Filament\Resources\RiddleResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRiddles extends ManageRecords
{
    protected static string $resource = RiddleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
