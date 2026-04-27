<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Firmware extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name', 'notes'];

    // set table
    protected $table = 'firmwares';

    protected $fillable = [
        'name',
        'device_code',
        'version',
        'bin_file',
        'is_active',
        'notes'
    ];
}
