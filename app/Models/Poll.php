<?php

namespace App\Models;

use App\DB;
use Exception;
use PDO;

class Poll
{
    public ?int $id;
    public ?int $user_id;
    public ?string $title;
    public bool $published = false;
    public ?array $questions;
    public string $created_at;
    public string $updated_at;

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
    }

    /**
     * Get poll model by ID
     *
     * @param $id
     *
     * @return \App\Models\Poll
     */
    public static function getById($id): Poll
    {
        $db = DB::getConnection();

        $resultQuery = $db->query("SELECT * FROM polls WHERE id = $id");
        $result = $resultQuery->fetchAll(PDO::FETCH_ASSOC)[0];

        $poll = new Poll();
        $poll->id = $result['id'];
        $poll->user_id = $result['user_id'];
        $poll->title = $result['title'];
        $poll->published = $result['published'];
        $poll->created_at = $result['created_at'];
        $poll->updated_at = $result['updated_at'];

        return $poll;
    }

    /**
     * Get list of polls data without pagination
     *
     * @return array
     */
    public static function getList(): array
    {
        $db = DB::getConnection();

        $resultQuery = $db->query(
            "SELECT p.id, p.title, p.published, p.created_at, COUNT(pvh.question_id) as votes
                FROM polls as p
                LEFT JOIN poll_voting_history AS pvh ON p.id = pvh.poll_id
                GROUP BY p.id HAVING published = 1"
        );

        return $resultQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get list of polls by user id without pagination
     *
     * @param int $userId
     *
     * @return array
     */
    public static function getListByUserId(int $userId): array
    {
        $db = DB::getConnection();

        $resultQuery = $db->query("SELECT id, title, published, created_at FROM polls WHERE user_id = $userId");

        return $resultQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Store chosen votes
     *
     * @param int   $pollId
     * @param array $votes
     *
     * @return void
     */
    public static function storeVotes(int $pollId, array $votes): void
    {
        $db = DB::getConnection();
        $userId = User::getCurrentId();
        $created_at = date('Y-m-d h:i:s');

        try {
            $db->beginTransaction();

            foreach ($votes as $questionId => $answerId) {
                $db->exec(
                    "INSERT INTO poll_voting_history (poll_id, question_id, answer_id, user_id, created_at, updated_at) 
                    VALUES ('$pollId', '$questionId', '$answerId', '$userId', '$created_at', '$created_at')"
                );

                $db->exec("UPDATE poll_answers SET votes = votes + 1 WHERE id = $answerId");
            }

            $db->commit();
        } catch (Exception) {
            $db->rollBack();
        }
    }

    /**
     * Save all poll data with relationships
     *
     * @param int $userId
     *
     * @return void
     */
    public function saveWithRelations(int $userId): void
    {
        $db = DB::getConnection();
        $created_at = date('Y-m-d h:i:s');
        $isPublished = (int)$this->published;

        try {
            $db->beginTransaction();

            $db->exec(
                "INSERT INTO polls (user_id, title, published, created_at, updated_at) 
                    VALUES ('$userId', '$this->title', '$isPublished', '$created_at', '$created_at')"
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
        } catch (Exception) {
            $db->rollBack();
        }
    }

    /**
     * Get array of related questions to the poll
     *
     * @return array
     */
    public function getQuestions(): array
    {
        $db = DB::getConnection();

        $resultQuery = $db->query(
            "SELECT pq.id AS question_id,
            pq.title AS question_title,
            pa.id AS answer_id,
            pa.title AS answer_title
        FROM poll_questions AS pq
        JOIN poll_answers AS pa ON pq.id = pa.question_id
        WHERE pq.poll_id = $this->id"
        );

        $result = $resultQuery->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($result as $value) {
            $data[$value['question_id']]['title'] = $value['question_title'];
            $data[$value['question_id']]['answers'][$value['answer_id']] = $value['answer_title'];
        }

        return $data;
    }

    /**
     * Publish current poll
     *
     * @return void
     */
    public function publish(): void
    {
        $db = DB::getConnection();

        $db->query("UPDATE polls SET published = 1 WHERE id = $this->id");
    }

    /**
     * Delete poll
     *
     * @return void
     */
    public function delete(): void
    {
        $db = DB::getConnection();

        $db->query("DELETE FROM polls WHERE id = $this->id");
    }

}