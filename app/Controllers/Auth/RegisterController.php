<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Requests\Auth\RegisterRequest;

class RegisterController
{
    /**
     * Display the registration form view
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return require_once APP_ROOT . '/views/auth/register.php';
    }

    /**
     * Process registration form data
     *
     * @return void
     */
    public function store(): void
    {
        $validated = RegisterRequest::validated($_POST);

        $user = new User($validated);
        if ($user->save()) {
            $_SESSION[AUTHENTICATED_USER] = $user->id;
            header('Location: /dashboardw');
        }
    }
}