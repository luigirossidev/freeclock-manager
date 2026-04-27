<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuote extends Model
{
    protected $table = 'daily_quotes';

    protected $fillable = [
        'day',
        'quote_id',
        'locale',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }


}
