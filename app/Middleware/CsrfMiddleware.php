<?php

namespace app\Middleware;

use pronajem\base\Middleware;
use pronajem\libs\CSRF;

/**
 * Verifies CSRF token for state-changing requests.
 *
 * Sources:
 *  - hidden input (form POST) → $_POST['token']
 *  - X-CSRF-Token header (AJAX) → $_SERVER['HTTP_X_CSRF_TOKEN']
 *
 * AJAX tokens are not consumed on check, form tokens are single-use.
 */
class CsrfMiddleware implements Middleware
{
    public function handle(): void
    {
        if (!in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return;
        }

        $headerToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $isAjax = $headerToken !== '';

        $token = $isAjax ? $headerToken : ($_POST['token'] ?? '');

        if (!CSRF::checkCsrfToken($token, $isAjax)) {
            throw new \Exception('CSRF token is invalid or expired', 419);
        }

        CSRF::cleanup();
    }
}