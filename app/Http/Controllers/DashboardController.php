<?php

namespace App\Http\Controllers;

use App\Models\DailyQuote;
use App\Models\DailyRiddle;
use App\Models\Quote;
use App\Models\Riddle;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $lang = app()->getLocale();
        Carbon::setLocale($lang);
        $today = Carbon::now();

        $quote = $this->getDailyQuote($today, $lang);
        $riddle = $this->getDailyRiddle($today, $lang);

        $formattedDate = ucfirst($today->translatedFormat('l d F Y'));
        $showAnswer = $today->hour >= 18;

        return view('dashboard', compact('quote', 'riddle', 'formattedDate', 'showAnswer'));
    }

    private function getDailyQuote(Carbon $today, string $lang): ?Quote
    {
        $dailyQuote = DailyQuote::whereDate('day', $today->format('Y-m-d'))
            ->where('locale', $lang)
            ->first();

        if ($dailyQuote) {
            return $dailyQuote->quote;
        }

        $usedIds = DailyQuote::select('quote_id')
            ->where('locale', $lang)
            ->whereBetween('day', [
                $today->copy()->startOfYear()->format('Y-m-d'),
                $today->copy()->endOfYear()->format('Y-m-d'),
            ])
            ->pluck('quote_id')
            ->toArray();

        $quote = Quote::whereNotIn('id', $usedIds)
            ->whereHas('category', fn ($q) => $q->where('locale', $lang))
            ->inRandomOrder()
            ->first();

        if ($quote) {
            $dailyQuote = new DailyQuote;
            $dailyQuote->day = $today->format('Y-m-d');
            $dailyQuote->quote_id = $quote->id;
            $dailyQuote->locale = $lang;
            $dailyQuote->save();
        }

        return $quote;
    }

    private function getDailyRiddle(Carbon $today, string $lang): ?Riddle
    {
        $dailyRiddle = DailyRiddle::whereDate('day', $today->format('Y-m-d'))
            ->where('locale', $lang)
            ->first();

        if ($dailyRiddle) {
            return $dailyRiddle->riddle;
        }

        $usedIds = DailyRiddle::select('riddle_id')
            ->where('locale', $lang)
            ->whereBetween('day', [
                $today->copy()->startOfYear()->format('Y-m-d'),
                $today->copy()->endOfYear()->format('Y-m-d'),
            ])
            ->pluck('riddle_id')
            ->toArray();

        $riddle = Riddle::whereNotIn('id', $usedIds)
            ->whereHas('category', fn ($q) => $q->where('locale', $lang))
            ->inRandomOrder()
            ->first();

        if ($riddle) {
            $dailyRiddle = new DailyRiddle;
            $dailyRiddle->day = $today->format('Y-m-d');
            $dailyRiddle->riddle_id = $riddle->id;
            $dailyRiddle->locale = $lang;
            $dailyRiddle->save();
        }

        return $riddle;
    }
}
