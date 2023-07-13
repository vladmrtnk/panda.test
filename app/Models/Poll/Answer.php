<?php

namespace App\Models\Poll;

class Answer
{
    public $id;
    public $question_id;
    public $title;
    public $votes;
    public $created_at;
    public $updated_at;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }
}