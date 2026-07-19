<?php

namespace app\Middleware;

use pronajem\base\Middleware;

/**
 * Ensures the request method is POST.
 */
class PostMiddleware implements Middleware
{
    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new \Exception('Invalid request.', 405);
        }
    }
}