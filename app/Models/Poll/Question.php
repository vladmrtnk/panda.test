<?php

namespace App\Models\Poll;

use App\DB;

class Question
{
    public $id;
    public $title;
    public $created_at;
    public $updated_at;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $db = DB::getConection();
        $created_at = date('Y-m-d h:i:s');

        $query = $db->query(
            "INSERT INTO poll_questions (title, created_at, updated_at) VALUES ('$this->title', '$created_at', '$created_at')"
        );

        $this->id = $db->lastInsertId('poll_questions');
        $this->created_at = $created_at;
        $this->updated_at = $created_at;

        return (bool)$query;
    }
}