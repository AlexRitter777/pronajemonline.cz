<?php

namespace pronajem\libs;


class CSRF
{

    public static function crateCsrfInput()
    {

        $_SESSION['token'] = md5(uniqid(mt_rand(), true));

        return sprintf(' <input type="hidden" name="token" value="%s">',
            ($_SESSION['token']) ?? ''
        );

    }


    public static function checkCsrfToken(string $token)
    {

        if (!$token || $token !== $_SESSION['token']) {
            return false;
        }
        unset($_SESSION['token']);

        return true;
    }

}