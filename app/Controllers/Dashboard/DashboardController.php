<?php

namespace App\Controllers\Dashboard;

use App\Models\Poll;

class DashboardController
{
    /**
     * Display main dashboard page
     *
     * @return void
     */
    public function index(): void
    {
        $polls = Poll::getList();

        require_once APP_ROOT . '/views/dashboard/index.php';
    }
}