<?php


if (!function_exists('url_replace_query_param')) {

    /**
     * Replace or add query parameter to current URL.
     *
     * Example:
     * /products?page=2
     * ↓
     * url_replace_query_param('ordered', 'asc')
     * ↓
     * /products?page=2&ordered=asc
     */
    function url_replace_query_param(string $key, string $value): string
    {
        $url = $_SERVER['REQUEST_URI'];

        $parts = parse_url($url);

        $query = [];

        // Parse existing query string
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        // Replace/add parameter
        $query[$key] = $value;

        // Build final URL
        $path = $parts['path'] ?? '';

        $queryString = http_build_query($query);

        return $queryString
            ? $path . '?' . $queryString
            : $path;
    }
}