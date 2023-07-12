<?php

namespace App\Requests;

abstract class Request
{
    /**
     * Class for validation of input data from forms
     *
     * @param array $data
     *
     * @return array|null
     */
    abstract static function validated(array $data): ?array;
}