<?php

declare(strict_types=1);

namespace app\Middleware;

final class Auth
{
    public function handle()
    {
        if(!is_user_logged_in()){
           throw new \Exception('Stránka není nalezená', 404);
        }
    }
}