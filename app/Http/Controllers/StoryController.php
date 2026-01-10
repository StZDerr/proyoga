<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stories = Story::with('media')->latest()->get();

        return view('admin.stories.index', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'preview' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'media' => 'required|array|min:1',
            'media.*' => 'file|mimes:jpeg,png,jpg,mp4,webm,ogg,avi|max:10200',
        ], [
            'title.required' => 'Поле "Название" обязательно для заполнения.',
            'preview.required' => 'Превью обязательно.',
            'preview.image' => 'Превью должно быть изображением.',
            'media.required' => 'Пожалуйста, загрузите хотя бы одно фото или видео.',
            'media.*.mimes' => 'Медиа: разрешены только фото (jpeg, png, jpg) и видео (mp4, webm, ogg, avi).',
            'media.*.max' => 'Размер каждого медиафайла не должен превышать 10 МБ.',
        ]);

        $data = [
            'title' => $request->title,
        ];

        if ($request->hasFile('preview')) {
            $data['preview'] = $request->file('preview')->store('stories/previews', 'public');
        }

        $story = Story::create($data);

        // Загружаем все файлы media[] в stories/media и создаём записи в story_media
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('stories/media', 'public');
                $mime = $file->getMimeType() ?: '';
                $type = str_starts_with($mime, 'video') ? 'video' : 'photo';

                $story->media()->create([
                    'type' => $type,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.stories.index')
            ->with('success', 'История успешно добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
        $story->load('media');

        return view('admin.stories.show', compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Story $story)
    {
        $story->load('media');

        return view('admin.stories.edit', compact('story'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Story $story)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'preview' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:jpeg,png,jpg,mp4,webm,ogg,avi|max:10200',
        ], [
            'title.required' => 'Поле "Название" обязательно для заполнения.',
            'preview.image' => 'Превью должно быть изображением.',
            'media.*.mimes' => 'Медиа: разрешены только фото (jpeg, png, jpg) и видео (mp4, webm, ogg, avi).',
            'media.*.max' => 'Размер каждого медиафайла не должен превышать 10 МБ.',
        ]);

        $data = ['title' => $request->title];

        // Обновление превью
        if ($request->hasFile('preview')) {
            if ($story->preview) {
                Storage::disk('public')->delete($story->preview);
            }
            $data['preview'] = $request->file('preview')->store('stories/previews', 'public');
        }

        $story->update($data);

        // Добавляем дополнительные медиа
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('stories/media', 'public');
                $mime = $file->getMimeType() ?: '';
                $type = str_starts_with($mime, 'video') ? 'video' : 'photo';

                $story->media()->create([
                    'type' => $type,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.stories.edit', $story)
            ->with('success', 'История обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        // Удаляем превью
        if ($story->preview) {
            Storage::disk('public')->delete($story->preview);
        }

        // Удаляем все связанные файлы медиа
        foreach ($story->media as $m) {
            Storage::disk('public')->delete($m->path);
        }

        // Удаление модели удалит story_media записи (foreign key cascade)
        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', 'История удалена!');
    }

    /**
     * Remove a specific media from the story.
     */
    public function destroyMedia(Story $story, StoryMedia $media)
    {
        // Проверяем, что медиа принадлежит этой истории
        if ($media->story_id !== $story->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Проверяем, что останется хотя бы одно медиа
        if ($story->media()->count() <= 1) {
            return response()->json(['error' => 'Нельзя удалить последнее медиа. Должно остаться хотя бы одно.'], 422);
        }

        // Удаляем файл
        Storage::disk('public')->delete($media->path);

        // Удаляем запись из БД
        $media->delete();

        return response()->json(['success' => true, 'message' => 'Медиа удалено!']);
    }
}
