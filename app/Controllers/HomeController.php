<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        require_once APP_ROOT . '/views/index.php';
    }
}