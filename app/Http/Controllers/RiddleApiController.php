<?php

namespace App\Http\Controllers;

use App\Http\Resources\DailyRiddleApiResource;
use App\Models\DailyRiddle;
use App\Models\Riddle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiddleApiController extends Controller
{
    public function dailyRiddle(string $lang = 'it')
    {
        $today = Carbon::now();

        $riddleOfTheDay = DailyRiddle::whereDate('day', $today->format('Y-m-d'))
            ->where('locale', $lang)
            ->first();

        if (!$riddleOfTheDay){
            // Unique Riddle of the Year
            $idYearRiddles = DailyRiddle::select('riddle_id')
                ->where('locale', $lang)
                ->whereBetween('day', [$today->copy()->startOfYear()->format('Y-m-d'), $today->copy()->endOfYear()->format('Y-m-d')])->get();
            $ids = [];
            foreach ($idYearRiddles as $idYearRiddle ){
                array_push($ids, $idYearRiddle->riddle_id);
            }
            $riddle = Riddle::whereNotIn('id', $ids)
                ->whereHas('category', fn ($q) => $q->where('locale', $lang))
                ->inRandomOrder()
                ->first();

            if (!$riddle) {
                // Tutti gli elementi sono gia' stati usati quest'anno: invece di
                // restituire 404 ricomincia il giro dal meno recente.
                $riddle = $this->leastRecentlyUsedRiddle($lang);
            }

            if (!$riddle) {
                return response()->json(['message' => 'No riddles available for this language'], 404);
            }

            $dailyRiddle = new DailyRiddle;
            $dailyRiddle->day = $today->format('Y-m-d');
            $dailyRiddle->riddle_id = $riddle->id;
            $dailyRiddle->locale = $lang;
            $dailyRiddle->save();
            return new DailyRiddleApiResource($riddle);
        }else {
            return new DailyRiddleApiResource($riddleOfTheDay->riddle);
        }
    }

    /**
     * Riddle della lingua indicata usato meno di recente come elemento del giorno.
     */
    private function leastRecentlyUsedRiddle(string $lang): ?Riddle
    {
        $lastUse = DailyRiddle::selectRaw('riddle_id, MAX(day) AS last_day')
            ->where('locale', $lang)
            ->groupBy('riddle_id');

        return Riddle::select('riddles.*')
            ->whereHas('category', fn ($q) => $q->where('locale', $lang))
            ->leftJoinSub($lastUse, 'last_use', 'last_use.riddle_id', '=', 'riddles.id')
            ->orderBy('last_use.last_day')
            ->first();
    }
}
