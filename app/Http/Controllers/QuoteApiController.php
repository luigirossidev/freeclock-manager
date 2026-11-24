<?php

namespace App\Http\Controllers;

use App\Http\Resources\DailyQuoteApiResource;
use App\Models\DailyQuote;
use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuoteApiController extends Controller
{
    public function dailyQuote(string $lang = 'it')
    {
        $today = Carbon::now();

        $quoteOfTheDay = DailyQuote::whereDate('day', $today->format('Y-m-d'))
            ->where('locale', $lang)
            ->first();

        if (!$quoteOfTheDay){
            // Unique Quote of the Year
            $idYearQuotes = DailyQuote::select('quote_id')
                ->where('locale', $lang)
                ->whereBetween('day', [$today->copy()->startOfYear()->format('Y-m-d'), $today->copy()->endOfYear()->format('Y-m-d')])->get();
            $ids = [];
            foreach ($idYearQuotes as $idYearQuote ){
                array_push($ids, $idYearQuote->quote_id);
            }
            $quote = Quote::whereNotIn('id', $ids)
                ->whereHas('category', fn ($q) => $q->where('locale', $lang))
                ->inRandomOrder()
                ->first();

            if (!$quote) {
                // Tutti gli elementi sono gia' stati usati quest'anno: invece di
                // restituire 404 ricomincia il giro dal meno recente.
                $quote = $this->leastRecentlyUsedQuote($lang);
            }

            if (!$quote) {
                return response()->json(['message' => 'No quotes available for this language'], 404);
            }

            $dailyQuote = new DailyQuote;
            $dailyQuote->day = $today->format('Y-m-d');
            $dailyQuote->quote_id = $quote->id;
            $dailyQuote->locale = $lang;
            $dailyQuote->save();
            return new DailyQuoteApiResource($quote);
        }else {
            return new DailyQuoteApiResource($quoteOfTheDay->quote);
        }
    }

    /**
     * Quote della lingua indicata usato meno di recente come elemento del giorno.
     */
    private function leastRecentlyUsedQuote(string $lang): ?Quote
    {
        $lastUse = DailyQuote::selectRaw('quote_id, MAX(day) AS last_day')
            ->where('locale', $lang)
            ->groupBy('quote_id');

        return Quote::select('quotes.*')
            ->whereHas('category', fn ($q) => $q->where('locale', $lang))
            ->leftJoinSub($lastUse, 'last_use', 'last_use.quote_id', '=', 'quotes.id')
            ->orderBy('last_use.last_day')
            ->first();
    }
}
