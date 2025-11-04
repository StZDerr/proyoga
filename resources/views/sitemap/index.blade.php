<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($allPages as $page)
        <url>
            <loc>{{ url($page->url) }}</loc>
            <lastmod>
                @if (isset($page->last_modified) && $page->last_modified)
                    {{ $page->last_modified->format('Y-m-d') }}
                @elseif (isset($page->updated_at) && $page->updated_at)
                    {{ $page->updated_at->format('Y-m-d') }}
                @else
                    {{ now()->format('Y-m-d') }}
                @endif
            </lastmod>
            <changefreq>{{ $page->changefreq }}</changefreq>
            <priority>{{ $page->priority }}</priority>
        </url>
    @endforeach
</urlset>
