<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($pages as $page)
        <url>
            <loc>{{ url($page->url) }}</loc>
            <lastmod>
                {{ $page->last_modified ? $page->last_modified->format('Y-m-d') : $page->updated_at->format('Y-m-d') }}
            </lastmod>
            <changefreq>{{ $page->changefreq }}</changefreq>
            <priority>{{ $page->priority }}</priority>
        </url>
    @endforeach
</urlset>
