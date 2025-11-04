<?php

namespace App\Helpers;

use App\Models\PageContent;

class PageContentHelper
{
    /**
     * Получить мета-данные для страницы
     */
    public static function getMeta($slug, $defaultTitle = null, $defaultDescription = null)
    {
        $page = PageContent::getBySlug($slug);

        if ($page) {
            return [
                'title' => $page->title,
                'description' => $page->description,
                'keywords' => $page->keywords,
                'og_title' => $page->seo_data['og_title'] ?? $page->title,
                'og_description' => $page->seo_data['og_description'] ?? $page->description,
                'og_image' => $page->seo_data['og_image'] ?? null,
            ];
        }

        return [
            'title' => $defaultTitle ?? 'ИстокиЯ',
            'description' => $defaultDescription ?? 'Студия йоги ИстокиЯ',
            'keywords' => null,
            'og_title' => $defaultTitle ?? 'ИстокиЯ',
            'og_description' => $defaultDescription ?? 'Студия йоги ИстокиЯ',
            'og_image' => null,
        ];
    }

    /**
     * Получить контент страницы
     */
    public static function getContent($slug)
    {
        $page = PageContent::getBySlug($slug);

        return $page ? $page->content : null;
    }

    /**
     * Проверить, существует ли страница
     */
    public static function exists($slug)
    {
        return PageContent::pageExists($slug);
    }
}
