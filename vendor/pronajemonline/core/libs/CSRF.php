<?php

namespace pronajem\libs;

class CSRF
{
    private const TOKEN_TTL = 600; // 10 minutes
    private const SESSION_KEY = 'csrf_tokens';

    /**
     * Create CSRF hidden input
     * Returns HTML input element with token value
     */
    public static function createCsrfInput(): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }

        $token = bin2hex(random_bytes(32));

        $_SESSION[self::SESSION_KEY][$token] = time() + self::TOKEN_TTL;

        return sprintf(
            '<input type="hidden" name="token" value="%s">',
            htmlspecialchars($token, ENT_QUOTES, 'UTF-8')
        );
    }

    public static function createCsrfToken(): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }

        $token = bin2hex(random_bytes(32));

        $_SESSION[self::SESSION_KEY][$token] = time() + self::TOKEN_TTL;

        return $token;
    }

    /**
     * Check CSRF token
     */
    public static function checkCsrfToken(string $token, bool $ajax = false): bool
    {
        if (
            !$token ||
            !isset($_SESSION[self::SESSION_KEY][$token])
        ) {
            return false;
        }

        $expires = $_SESSION[self::SESSION_KEY][$token];

        // Expired token
        if ($expires < time()) {
            unset($_SESSION[self::SESSION_KEY][$token]);
            return false;
        }

        // For non-ajax requests, invalidate the token after successful check
        if (!$ajax) {
            unset($_SESSION[self::SESSION_KEY][$token]);
        }

        return true;
    }

    /**
     * Clean up expired tokens from the session
     */
    public static function cleanup(): void
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            return;
        }

        foreach ($_SESSION[self::SESSION_KEY] as $t => $expires) {
            if ($expires < time()) {
                unset($_SESSION[self::SESSION_KEY][$t]);
            }
        }
    }
}
