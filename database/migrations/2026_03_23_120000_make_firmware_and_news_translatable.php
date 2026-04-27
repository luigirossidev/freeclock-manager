<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Converte i dati esistenti di firmwares in formato JSON translatable
        $firmwares = DB::table('firmwares')->get();
        foreach ($firmwares as $firmware) {
            $name = json_encode(['it' => $firmware->name]);
            $notes = $firmware->notes ? json_encode(['it' => $firmware->notes]) : null;
            DB::table('firmwares')->where('id', $firmware->id)->update([
                'name' => $name,
                'notes' => $notes,
            ]);
        }

        // Converte le colonne di firmwares in JSON
        Schema::table('firmwares', function (Blueprint $table) {
            $table->json('name')->change();
            $table->json('notes')->nullable()->change();
        });

        // Converte i dati esistenti di news in formato JSON translatable
        $news = DB::table('news')->get();
        foreach ($news as $item) {
            $title = json_encode(['it' => $item->title]);
            $content = $item->content ? json_encode(['it' => $item->content]) : null;
            DB::table('news')->where('id', $item->id)->update([
                'title' => $title,
                'content' => $content,
            ]);
        }

        // Converte le colonne di news in JSON
        Schema::table('news', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('content')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Ripristina firmwares
        Schema::table('firmwares', function (Blueprint $table) {
            $table->string('name')->change();
            $table->longText('notes')->nullable()->change();
        });

        $firmwares = DB::table('firmwares')->get();
        foreach ($firmwares as $firmware) {
            $name = json_decode($firmware->name, true);
            $notes = $firmware->notes ? json_decode($firmware->notes, true) : null;
            DB::table('firmwares')->where('id', $firmware->id)->update([
                'name' => is_array($name) ? ($name['it'] ?? '') : $firmware->name,
                'notes' => is_array($notes) ? ($notes['it'] ?? null) : $firmware->notes,
            ]);
        }

        // Ripristina news
        Schema::table('news', function (Blueprint $table) {
            $table->string('title')->change();
            $table->longText('content')->nullable()->change();
        });

        $news = DB::table('news')->get();
        foreach ($news as $item) {
            $title = json_decode($item->title, true);
            $content = $item->content ? json_decode($item->content, true) : null;
            DB::table('news')->where('id', $item->id)->update([
                'title' => is_array($title) ? ($title['it'] ?? '') : $item->title,
                'content' => is_array($content) ? ($content['it'] ?? null) : $item->content,
            ]);
        }
    }
};
