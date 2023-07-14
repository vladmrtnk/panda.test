<?php

namespace App\Controllers\Dashboard;

use App\Models\Poll;
use App\Models\User;
use App\Requests\PollRequest;

class PollController
{
    /**
     * Display page with authorized user polls
     *
     * @return void
     */
    public function index(): void
    {
        $userId = User::getCurrentId();
        $polls = Poll::getListByUserId($userId);

        require_once APP_ROOT . '/views/dashboard/poll/index.php';
    }

    /**
     * Display single poll view
     *
     * @param int $id
     *
     * @return void
     */
    public function show(int $id): void
    {
        $poll = Poll::getById($id);

        require_once APP_ROOT . '/views/dashboard/poll/show.php';
    }

    /**
     * Store chosen votes data
     *
     * @param int $id
     *
     * @return void
     */
    public function storeVotes(int $id): void
    {
        $data = $_POST;

        Poll::storeVotes($id, $data);

        header('Location: /dashboard');
        die;
    }

    /**
     * Display creating polls view
     *
     * @return void
     */
    public function create(): void
    {
        require_once APP_ROOT . '/views/dashboard/poll/create.php';
    }

    /**
     * Store new poll
     *
     * @return void
     */
    public function store(): void
    {
        $validated = PollRequest::validated($_POST);
        $userId = User::getCurrentId();

        $poll = new Poll($validated);
        $poll->saveWithRelations($userId);

        header('Location: /dashboard/poll');
        die;
    }

    /**
     * Publish poll
     *
     * @return void
     */
    public function publish(): void
    {
        $pollId = $_POST['id'];

        $poll = Poll::getById($pollId);
        $poll->publish();

        header('Location: /dashboard/poll');
        die;
    }

    /**
     * Delete poll
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $poll = Poll::getById($id);
        $poll->delete();

        header('Location: /dashboard/poll');
        die;
    }
}