<?php

namespace App\Controllers\Dashboard;

use App\Models\Poll\Poll;
use App\Models\Poll\Question;
use App\Requests\PollRequest;

class PollController
{
    public function index(): void
    {
        require_once APP_ROOT . '/views/dashboard/poll/index.php';
    }

    public function create(): void
    {
        require_once APP_ROOT . '/views/dashboard/poll/create.php';
    }

    public function store()
    {
        $data = $_POST;

        $poll = new Poll($data);
        $poll->saveWithRelations();
    }
}