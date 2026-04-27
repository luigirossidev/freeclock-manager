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
}
