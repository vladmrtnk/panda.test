<?php

namespace App\Components;

class Message
{
    /**
     * Create a flash message
     *
     * @param string $name
     * @param string $message
     * @param string $type
     *
     * @return void
     */
    public static function create(string $name, string $message, string $type): void
    {
        if (isset($_SESSION[MESSAGES][$name])) {
            unset($_SESSION[MESSAGES][$name]);
        }

        $_SESSION[MESSAGES][$name] = ['message' => $message, 'type' => $type];
    }

    /**
     * Format a flash message
     *
     * @param array $flash_message
     *
     * @return string
     */
    private static function format(array $flash_message): string
    {
        return sprintf(
            '<div class="invalid-feedback alert-%s">%s</div>',
            $flash_message['type'],
            $flash_message['message']
        );
    }

    /**
     * Display a flash message
     *
     * @param string $name
     *
     * @return string|null
     */
    public static function show(string $name): ?string
    {
        if (!isset($_SESSION[MESSAGES][$name])) {
            return null;
        }

        $flash_message = $_SESSION[MESSAGES][$name];

        unset($_SESSION[MESSAGES][$name]);

        return self::format($flash_message);
    }

    /**
     * Check for any errors
     *
     * @param string|null $nameError
     *
     * @return bool
     */
    public static function hasErrors(string $nameError = null): bool
    {
        if (!isset($_SESSION[MESSAGES])) {
            return false;
        }

        if (isset($nameError)) {
            return array_key_exists($nameError, $_SESSION[MESSAGES]);
        }

        foreach ($_SESSION[MESSAGES] as $message) {
            if ($message['type'] == MESSAGE_ERROR) {
                return true;
            }
        }

        return false;
    }
}