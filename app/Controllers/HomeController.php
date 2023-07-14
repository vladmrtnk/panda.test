<?php

namespace App\Controllers;

class HomeController
{
    /**
     * Display unauthorized home page
     *
     * @return void
     */
    public function index(): void
    {
        require_once APP_ROOT . '/views/index.php';
    }
}