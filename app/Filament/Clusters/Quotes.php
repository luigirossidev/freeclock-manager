<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Quotes extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-c-chat-bubble-bottom-center-text';

    public static function getNavigationLabel(): string
    {
        return __('quotes.plural');
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return '';
    }
}
