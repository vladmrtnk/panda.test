<?php

namespace App\Models\Poll;

use App\DB;
use Exception;
use PDO;

class Poll
{
    public $title;
    public $published = false;
    public $questions;

    /**]
     * @param string|array|null $title
     * @param array|null        $questions
     */
    public function __construct(string|array $title = null, array $questions = null)
    {
        if (is_array($title)) {
            $this->title = $title['title'];
            $this->questions = $title['questions'];
        } else {
            $this->title = $title;
            $this->questions = $questions;
        }
    }

    public function saveWithRelations()
    {
        $db = DB::getConection();
        $created_at = date('Y-m-d h:i:s');
        $isPublished = (int)$this->published;

        try {
            $db->beginTransaction();

            $db->exec("INSERT INTO polls (title, published, created_at, updated_at) VALUES ('$this->title', '{$isPublished}', '$created_at', '$created_at')");

            $pollId = $db->lastInsertId('polls');
            foreach ($this->questions as $question) {
                $db->exec("INSERT INTO poll_questions (poll_id, title, created_at, updated_at) VALUES ('$pollId', '{$question['title']}', '$created_at', '$created_at')");
                $questionId = $db->lastInsertId('poll_questions');

                foreach ($question['answers'] as $answer) {
                    $db->exec("INSERT INTO poll_answers (question_id, title, created_at, updated_at) VALUES ('$questionId', '$answer', '$created_at', '$created_at')");
                }
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            echo "Failed: " . $e->getMessage();
        }
    }
}