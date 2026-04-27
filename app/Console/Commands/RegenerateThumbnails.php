<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class RegenerateThumbnails extends Command
{
    protected $signature = 'news:regenerate-thumbnails';

    protected $description = 'Rigenera i thumbnail per tutte le news con immagine';

    public function handle()
    {
        $news = News::whereNotNull('image')->get();

        if ($news->isEmpty()) {
            $this->info('Nessuna news con immagine trovata.');
            return 0;
        }

        $this->info("Trovate {$news->count()} news con immagine.");
        $bar = $this->output->createProgressBar($news->count());

        foreach ($news as $item) {
            $imagePath = Storage::disk('public')->path($item->image);

            if (!file_exists($imagePath)) {
                $this->newLine();
                $this->warn("Immagine non trovata: {$item->image}");
                $bar->advance();
                continue;
            }

            // Genera nome thumbnail
            $pathInfo = pathinfo($item->image);
            $thumbnailName = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.jpg';

            // Crea thumbnail 300x200 con compressione
            $image = Image::read($imagePath);
            $image->cover(300, 200);

            // Salva thumbnail con qualità ridotta (70%)
            $thumbnailPath = Storage::disk('public')->path($thumbnailName);
            $image->toJpeg(70)->save($thumbnailPath);

            // Aggiorna record senza trigger observer
            $item->updateQuietly(['thumbnail' => $thumbnailName]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Thumbnail rigenerati con successo!');

        return 0;
    }
}
