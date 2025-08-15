<?php

namespace PHPFramework\Middleware;

class Auth
{
    public function handle(): void
    {
        if (!check_auth()) {
//            dump(LOGIN_PAGE);
            response()->redirect(LOGIN_PAGE);
        }
    }

}