<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Requests\Auth\LoginRequest;

class LoginController
{
    /**
     * Display the authentication form view.
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return require_once APP_ROOT . '/views/auth/login.php';
    }

    /**
     * Process authentication form data
     *
     * @return void
     */
    public function store(): void
    {
        $validated = LoginRequest::validated($_POST);

        $user = User::find($validated['email']);

        if ($user->authenticate($_POST['password'])) {
            header('Location: /dashboard/poll');
            die;
        }
    }
}