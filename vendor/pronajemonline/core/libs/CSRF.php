<?php

namespace pronajem\libs;


class CSRF
{

    public static function createCsrfInput()
    {

        $_SESSION['token'] = md5(uniqid(mt_rand(), true));

        return sprintf(' <input type="hidden" name="token" value="%s">',
            ($_SESSION['token']) ?? ''
        );

    }


    public static function checkCsrfToken(string $token, bool $ajax = false)
    {

        if (!$token || $token !== $_SESSION['token']) {
            return false;
        }

        if(!$ajax){
            unset($_SESSION['token']);
        }

        return true;
    }

}