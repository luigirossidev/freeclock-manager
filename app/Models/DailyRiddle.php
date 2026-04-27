<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyRiddle extends Model
{
    protected $table = 'daily_riddles';

    protected $fillable = [
        'day',
        'riddle_id',
        'locale',
    ];

    public function riddle()
    {
        return $this->belongsTo(Riddle::class, 'riddle_id');
    }

}
