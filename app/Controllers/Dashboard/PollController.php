<?php

namespace App\Controllers\Dashboard;

use App\Models\Poll\Poll;
use App\Models\User;

class PollController
{
    public function index(): void
    {
        $userId = User::getCurrentId();
        $polls = (new Poll())->getAllForDashboard($userId);

        require_once APP_ROOT . '/views/dashboard/poll/index.php';
    }

    public function show(int $id)
    {
        $poll = Poll::getById($id);

        require_once APP_ROOT . '/views/dashboard/poll/show.php';
    }

    public function storeVotes(int $id)
    {
        $data = $_POST;

        Poll::storeVotes($id, $data);

        header('Location: /dashboard');
        die;
    }

    public function create(): void
    {
        require_once APP_ROOT . '/views/dashboard/poll/create.php';
    }

    public function store()
    {
        $data = $_POST;
        $userId = User::getCurrentId();

        $poll = new Poll($data);
        $poll->saveWithRelations($userId);

        header('Location: /dashboard/poll');
        die;
    }

    public function publish()
    {
        $pollId = $_POST['id'];

        $poll = Poll::getById($pollId);
        $poll->publish();

        header('Location: /dashboard/poll');
        die;
    }
}