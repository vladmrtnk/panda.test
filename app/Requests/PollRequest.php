<?php

namespace App\Requests;

class PollRequest extends Request
{
    /**
     * There are must be validation of creating Polls, but I haven't enough time to do it
     *
     * @inheritDoc
     */
    static function validated(array $data): ?array
    {
        return $data;
    }
}