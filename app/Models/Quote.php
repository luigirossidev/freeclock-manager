<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';

    protected $fillable = [
        'quote',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(QuotesCategory::class, 'category_id');
    }
}
