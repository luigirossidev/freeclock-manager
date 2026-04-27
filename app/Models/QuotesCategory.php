<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotesCategory extends Model
{
    protected $table = 'quotes_categories';

    protected $fillable = [
        'name',
        'locale',
    ];

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'category_id');
    }

}
