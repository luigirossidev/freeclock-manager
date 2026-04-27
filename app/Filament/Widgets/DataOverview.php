<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use App\Models\Riddle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DataOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $quotesTotal = Quote::count();
        $quotesIt = Quote::whereHas('category', fn ($q) => $q->where('locale', 'it'))->count();
        $quotesEn = Quote::whereHas('category', fn ($q) => $q->where('locale', 'en'))->count();

        $riddlesTotal = Riddle::count();
        $riddlesIt = Riddle::whereHas('category', fn ($q) => $q->where('locale', 'it'))->count();
        $riddlesEn = Riddle::whereHas('category', fn ($q) => $q->where('locale', 'en'))->count();

        return [
            Stat::make(__('quotes.plural'), $quotesTotal)
                ->description("IT: {$quotesIt} | EN: {$quotesEn}")
                ->icon('heroicon-c-chat-bubble-bottom-center-text'),
            Stat::make(__('riddles.plural'), $riddlesTotal)
                ->description("IT: {$riddlesIt} | EN: {$riddlesEn}")
                ->icon('heroicon-c-question-mark-circle'),
        ];
    }
}
