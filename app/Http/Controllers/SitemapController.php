<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap for search engine crawlers.
     */
    public function index(): Response
    {
        $baseUrl = url('/');

        $staticPages = [
            ['loc' => $baseUrl, 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $baseUrl . '/about', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/services', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/portfolio', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/pricing', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/blog', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/contact', 'changefreq' => 'monthly', 'priority' => '0.7'],
        ];

        $blogPosts = BlogPost::where('is_published', true)->latest('updated_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($staticPages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($page['loc']) . '</loc>';
            $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $page['priority'] . '</priority>';
            $xml .= '</url>';
        }

        foreach ($blogPosts as $post) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($baseUrl . '/blog/' . $post->slug) . '</loc>';
            $xml .= '<lastmod>' . $post->updated_at->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
