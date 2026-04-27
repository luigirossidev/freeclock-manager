<?php

namespace App\Filament\Resources\QuotesCategoryResource\Pages;

use App\Filament\Resources\QuotesCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageQuotesCategories extends ManageRecords
{
    protected static string $resource = QuotesCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
