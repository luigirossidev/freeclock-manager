<?php

namespace App\Models;

use App\Observers\NewsObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Translatable\HasTranslations;

#[ObservedBy([NewsObserver::class])]
class News extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['title', 'content'];

    protected $table = 'news';

    protected $fillable = [
        'title',
        'image',
        'thumbnail',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Riassunto automatico: estrae i primi 150 caratteri dal testo senza tag HTML
     */
    protected function summary(): Attribute
    {
        return Attribute::make(
            get: function () {
                $plainText = strip_tags($this->content);
                if (strlen($plainText) <= 150) {
                    return $plainText;
                }
                return substr($plainText, 0, 150) . '...';
            }
        );
    }

    /**
     * Scope per le news pubblicate
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
}
