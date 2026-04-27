<?php

namespace App\Filament\Resources\RiddlesCategoryResource\Pages;

use App\Filament\Resources\RiddlesCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRiddlesCategories extends ManageRecords
{
    protected static string $resource = RiddlesCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
