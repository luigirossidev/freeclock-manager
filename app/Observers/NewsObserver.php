<?php

namespace App\Observers;

use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class NewsObserver
{
    /**
     * Handle the News "saving" event.
     */
    public function saving(News $news): void
    {
        // Se l'immagine è cambiata, genera il thumbnail
        if ($news->isDirty('image') && $news->image) {
            $this->generateThumbnail($news);
        }

        // Se l'immagine è stata rimossa, rimuovi anche il thumbnail
        if ($news->isDirty('image') && !$news->image && $news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
            $news->thumbnail = null;
        }
    }

    /**
     * Handle the News "deleted" event.
     */
    public function deleted(News $news): void
    {
        // Rimuovi immagine e thumbnail quando la news viene eliminata
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }
    }

    /**
     * Genera il thumbnail dall'immagine principale
     */
    protected function generateThumbnail(News $news): void
    {
        $imagePath = Storage::disk('public')->path($news->image);

        if (!file_exists($imagePath)) {
            return;
        }

        // Genera nome thumbnail
        $pathInfo = pathinfo($news->image);
        $thumbnailName = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.jpg';

        // Crea thumbnail 300x200 con compressione
        $image = Image::read($imagePath);
        $image->cover(300, 200);

        // Salva thumbnail con qualità ridotta (70%)
        $thumbnailPath = Storage::disk('public')->path($thumbnailName);
        $image->toJpeg(70)->save($thumbnailPath);

        $news->thumbnail = $thumbnailName;
    }
}
