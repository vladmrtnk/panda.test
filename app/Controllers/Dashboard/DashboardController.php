<?php

namespace App\Controllers\Dashboard;

use App\Models\Poll\Poll;
use App\Models\User;

class DashboardController
{
    public function index(): void
    {
        $polls = Poll::getList();

        require_once APP_ROOT . '/views/dashboard/index.php';
    }
}