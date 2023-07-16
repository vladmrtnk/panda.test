<?php

namespace App\Models;

use App\DB;
use Cassandra\Exception\UnauthorizedException;
use PDO;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class User
{
    public int $id;
    public ?string $email;
    private ?string $password;
    public string $created_at;
    public string $updated_at;

    /**
     * @param string|array|null $email
     * @param string|null       $password
     */
    public function __construct(string|array|null $email = null, string $password = null)
    {
        if (is_array($email)) {
            $this->email = $email['email'];
            $this->password = $email['password'];
        } else {
            $this->email = $email;
            $this->password = $password;
        }
    }

    /**
     * Get current authenticated user id
     *
     * @return int
     */
    public static function getCurrentId(): int
    {
        return $_SESSION[AUTHENTICATED_USER];
    }

    /**
     * Find user by ID or Email
     *
     * @param int|string $needle
     *
     * @return \App\Models\User|false
     * @throws \Exception
     */
    public static function find(int|string $needle): bool|User
    {
        $db = DB::getConnection();

        if (is_int($needle)) {
            $result = $db->query("SELECT * from users where id = $needle");
        } else {
            $result = $db->query("SELECT * from users where email = '$needle'");
        }

        $data = $result->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new \Exception('User is not found', 401);
        }

        $user = new User();
        $user->id = $data['id'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->created_at = $data['created_at'];
        $user->updated_at = $data['updated_at'];

        return $user;
    }

    /**
     * Check if user exist
     *
     * @param string $email
     *
     * @return bool
     */
    public static function exist(string $email): bool
    {
        $db = DB::getConnection();

        $query = $db->query("SELECT id FROM users WHERE email = '$email'");

        return (bool)$query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Save user data
     *
     * @return bool
     */
    public function save(): bool
    {
        $db = DB::getConnection();

        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d h:i:s');

        $query = $db->query(
            "INSERT INTO users (email, password, created_at, updated_at) VALUES ('$this->email', '$hash', '$created_at', '$created_at')"
        );
        $this->id = $db->lastInsertId('users');
        $this->created_at = $created_at;
        $this->updated_at = $created_at;

        return (bool)$query;
    }

    /**
     * Authenticate user
     *
     * @param  $password
     *
     * @return void
     * @throws \Exception
     */
    public function authenticate($password): void
    {
        $auth = password_verify($password, $this->password);

        if ($auth) {
            $_SESSION[AUTHENTICATED_USER] = $this->id;
        } else {
            throw new \Exception('Email or password is incorrect', 401);
        }
    }
}