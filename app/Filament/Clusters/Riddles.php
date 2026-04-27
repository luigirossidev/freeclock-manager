<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Riddles extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-c-question-mark-circle';

    public static function getNavigationLabel(): string
    {
        return __('riddles.plural');
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return '';
    }
}
