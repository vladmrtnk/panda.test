<?php

namespace App\Models\Poll;

use App\DB;
use Exception;
use App\Models\User;
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

    public static function getById($id): Poll
    {
        $db = DB::getConection();

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

    public static function getList(): array
    {
        $db = DB::getConection();

        $resultQuery = $db->query(
            "SELECT p.id, p.title, p.published, p.created_at, COUNT(pvh.question_id) as votes
                FROM polls as p
                LEFT JOIN poll_voting_history AS pvh ON p.id = pvh.poll_id
                GROUP BY p.id"
        );

        $result = $resultQuery->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function storeVotes(int $pollId, array $votes)
    {
        $db = DB::getConection();
        $userId = User::getCurrentId();
        $created_at = date('Y-m-d h:i:s');

        try {
            $db->beginTransaction();

            foreach ($votes as $questionId => $answerId) {
                $db->exec("INSERT INTO poll_voting_history (poll_id, question_id, answer_id, user_id, created_at, updated_at) 
                    VALUES ('$pollId', '$questionId', '$answerId', '$userId', '$created_at', '$created_at')");

                $db->exec("UPDATE poll_answers SET votes = votes + 1 WHERE id = $answerId");
            }

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
        }
    }

    /**
     * Save all poll data with relationships
     *
     * @return $this
     */
    public function saveWithRelations(int $userId): void
    {
        $db = DB::getConection();
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
        } catch (Exception $e) {
            $db->rollBack();
        }
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function getAllByUserId(int $userId): array
    {
        $db = DB::getConection();

        $resultQuery = $db->query(
            "
            SELECT p.title AS pt,
                   p.published,
                   pq.title AS pqt,
                   pq.poll_id,
                   pa.id,
                   pa.title AS pat,
                   pa.question_id,
                   pa.votes
            FROM polls AS p
            JOIN poll_questions AS pq ON p.id = pq.poll_id
            JOIN poll_answers AS pa ON pq.id = pa.question_id
            WHERE user_id = '$userId'
        "
        );

        $result = $resultQuery->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($result as $value) {
            $data[$value['poll_id']]['title'] = $value['pt'];
            $data[$value['poll_id']]['questions'][$value['question_id']]['title'] = $value['pqt'];
            $data[$value['poll_id']]['questions'][$value['question_id']]['answers'][$value['id']] = $value['pat'];
        }

        return $data;
    }

    public function getQuestions()
    {
        $db = DB::getConection();

        $resultQuery = $db->query(
            "
            SELECT pq.id AS question_id,
                   pq.title AS question_title,
                   pa.id AS answer_id,
                   pa.title AS answer_title
            FROM poll_questions AS pq
            JOIN poll_answers AS pa ON pq.id = pa.question_id
            WHERE pq.poll_id = $this->id
        "
        );

        $result = $resultQuery->fetchAll(PDO::FETCH_ASSOC);


        $data = [];
        foreach ($result as $value) {
            $data[$value['question_id']]['title'] = $value['question_title'];
            $data[$value['question_id']]['answers'][$value['answer_id']] = $value['answer_title'];
        }

        return $data;
    }

    public function getAllForDashboard(int $userId): array
    {
        $db = DB::getConection();

        $resultQuery = $db->query("SELECT id, title, published, created_at FROM polls WHERE user_id = $userId");
        $result = $resultQuery->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Publish current poll
     *
     * @return bool
     */
    public function publish(): bool
    {
        $db = DB::getConection();

        $result = $db->query("UPDATE polls SET published = 1 WHERE id = $this->id");

        return (bool)$result;
    }
}