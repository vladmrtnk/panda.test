<?php

namespace App\Requests\Auth;

use App\Components\FormData;
use App\Components\Message;
use App\Models\User;
use App\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Validation login form data
     *
     * @param array $data
     *
     * @return array|null
     */
    static function validated(array $data): ?array
    {
        //Get valid email or false
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);

        if ($email && User::exist($email)) {
            return ['email' => $email];
        }

        //If email invalid or user is not exist, show error
        FormData::setOldData($_POST);
        Message::create(SIGN_IN_ERROR, 'Email or password is incorrect', MESSAGE_ERROR);

        header('Location: /login');
        die;
    }
}