<?php

namespace App\Controllers\Auth;

class LogoutController
{
    /**
     * Logout authorized user
     *
     * @return void
     */
    public function index(): void
    {
        $_SESSION[AUTHENTICATED_USER] = false;

        header('Location: /');
    }
}