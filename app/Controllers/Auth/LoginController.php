<?php

namespace App\Controllers\Auth;

use App\Components\FormData;
use App\Components\Message;
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

        try {
            $user = User::find($validated['email']);
            $user->authenticate($_POST['password']);
        } catch (\Exception $e) {
            FormData::setOldData($_POST);
            Message::create(SIGN_IN_ERROR, $e->getMessage(), MESSAGE_ERROR);

            header('Location: /login');
            die;
        }

        header('Location: /dashboard');
        die;
    }
}