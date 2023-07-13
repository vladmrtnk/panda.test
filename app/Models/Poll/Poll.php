<?php

namespace App\Models\Poll;

use App\DB;
use Exception;
use App\Models\User;
use PDO;

class Poll
{
    public ?string $title;
    public bool $published = false;
    public ?array $questions;
    public int $userId;

    /**
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

        $this->userId = User::getCurrentId();
    }

    /**
     * Save all poll data with relationships
     *
     * @return $this
     */
    public function saveWithRelations(): Poll
    {
        $db = DB::getConection();
        $created_at = date('Y-m-d h:i:s');
        $isPublished = (int)$this->published;

        try {
            $db->beginTransaction();

            $db->exec(
                "INSERT INTO polls (user_id, title, published, created_at, updated_at) 
                    VALUES ('$this->userId', '$this->title', '$isPublished', '$created_at', '$created_at')"
            );

            $pollId = $db->lastInsertId('polls');
            foreach ($this->questions as $question) {
                $db->exec(
                    "INSERT INTO poll_questions (poll_id, title, created_at, updated_at) 
                        VALUES ('$pollId', '{$question['title']}', '$created_at', '$created_at')"
                );
                $questionId = $db->lastInsertId('poll_questions');

                foreach ($question['answers'] as $answer) {
                    $db->exec(
                        "INSERT INTO poll_answers (question_id, title, created_at, updated_at) 
                            VALUES ('$questionId', '$answer', '$created_at', '$created_at')"
                    );
                }
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAll(int $userId = null): array
    {
        $db = DB::getConection();

        $resultQuery = $db->query(
            "
            SELECT p.title AS pt,
                   p.published,
                   pq.title AS pqt,
                   pa.title AS pat,
                   pa.question_id,
                   pa.votes
            FROM polls AS p
            JOIN poll_questions AS pq ON p.id = pq.poll_id
            JOIN poll_answers AS pa ON pq.id = pa.question_id
            WHERE user_id = '$this->userId'
        "
        );

        $result = $resultQuery->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($result as $value) {
            $data[$value['question_id']]['title'] = $value['pt'];
            $data[$value['question_id']]['questions'][] = $value['pqt'];
            //...
        }

        return $result;
    }
}