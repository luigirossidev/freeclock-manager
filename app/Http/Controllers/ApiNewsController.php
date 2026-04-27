<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiNewsController extends Controller
{
    /**
     * Elenco news paginato (titolo, thumbnail, riassunto)
     */
    public function index(Request $request)
    {
        app()->setLocale($request->get('lang', 'it'));

        $perPage = $request->get('per_page', 10);

        $news = News::published()
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);

        $news->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'thumbnail' => $item->thumbnail ? Storage::url($item->thumbnail) : null,
                'summary' => $item->summary,
                'published_at' => $item->published_at->toIso8601String(),
            ];
        });

        return response()->json($news);
    }

    /**
     * Singola news completa
     */
    public function show(Request $request, $id)
    {
        app()->setLocale($request->get('lang', 'it'));

        $news = News::published()->find($id);

        if ($news == null) {
            return response()->json(['error' => 'News not found'], 404);
        }

        return response()->json([
            'id' => $news->id,
            'title' => $news->title,
            'image' => $news->image ? Storage::url($news->image) : null,
            'content' => $news->content,
            'summary' => $news->summary,
            'published_at' => $news->published_at->toIso8601String(),
        ]);
    }
}
