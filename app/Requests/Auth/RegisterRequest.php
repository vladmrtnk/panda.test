<?php

namespace App\Requests\Auth;

use App\Components\FormData;
use App\Components\Message;
use App\Models\User;
use App\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Validation register form data
     *
     * @param array $data
     *
     * @return array|null
     */
    static function validated(array $data): ?array
    {
        //Get valid email and password or false
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($data['password'], FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^.{6,50}$/']]);

        if ($data['password'] != $data['second_password'] || !$password) {
            Message::create(INVALID_PASSWORDS, 'Enter the correct password. Min: 6 symbols', MESSAGE_ERROR);
        }

        if ($email) {
            if (User::exist($email)) {
                Message::create(INVALID_EMAIL, 'This email already exist', MESSAGE_ERROR);
            }
        } else {
            Message::create(INVALID_EMAIL, 'Enter the correct email', MESSAGE_ERROR);
        }

        if (Message::hasErrors()) {
            FormData::setOldData($_POST);
            header('Location: /register');
            die;
        }

        //If there is no error - return valid data
        return [
            'email'    => $email,
            'password' => $password
        ];
    }
}