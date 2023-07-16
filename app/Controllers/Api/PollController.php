<?php

namespace App\Controllers\Api;

use App\Models\Poll;
use App\Models\User;

class PollController
{
    /**
     * Get random poll current user
     *
     * @return void
     */
    public function show(): void
    {
        header('Content-Type: application/json');

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            http_response_code(401);
            echo json_encode([
                'status' => 401,
                'message'   => 'You have to authorize'
            ]);
            die;
        }

        try {
            $user = User::find($_SERVER['PHP_AUTH_USER']);
            $user->authenticate($_SERVER['PHP_AUTH_PW']);
            $poll = Poll::getRandomByUserId($user->id);
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            echo json_encode([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
            die;
        }

        echo json_encode([
            'status' => 200,
            'poll' => $poll
        ]);
    }
}