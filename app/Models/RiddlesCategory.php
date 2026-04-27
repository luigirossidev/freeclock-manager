<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiddlesCategory extends Model
{
    protected $table = 'riddles_categories';

    protected $fillable = [
        'name',
        'locale',
    ];

    public function riddles()
    {
        return $this->hasMany(Riddle::class, 'category_id');
    }

}
