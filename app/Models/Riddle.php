<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riddle extends Model
{
    protected $table = 'riddles';

    protected $fillable = [
        'riddle',
        'answer',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(RiddlesCategory::class, 'category_id');
    }
}
