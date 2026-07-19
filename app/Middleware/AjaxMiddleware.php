<?php

namespace app\Middleware;

use pronajem\base\Middleware;

/**
 * Ensures the request was made via AJAX.
 */
class AjaxMiddleware implements Middleware
{
    public function handle(): void
    {
        $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';

        if (strtolower($requestedWith) !== 'xmlhttprequest') {
            throw new \Exception('Invalid request.', 400);
        }
    }
}