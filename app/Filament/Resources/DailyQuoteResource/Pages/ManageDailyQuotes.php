<?php

namespace App\Filament\Resources\DailyQuoteResource\Pages;

use App\Filament\Resources\DailyQuoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDailyQuotes extends ManageRecords
{
    protected static string $resource = DailyQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
