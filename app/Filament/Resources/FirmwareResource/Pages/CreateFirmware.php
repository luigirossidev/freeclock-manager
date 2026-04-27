<?php

namespace App\Filament\Resources\FirmwareResource\Pages;

use App\Filament\Resources\FirmwareResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFirmware extends CreateRecord
{
    protected static string $resource = FirmwareResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
