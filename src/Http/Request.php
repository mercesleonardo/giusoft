<?php

namespace App\Http;

use JsonException;

class Request
{
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @throws JsonException
     */
    public static function body()
    {
        $json = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR) ?? [];

        return match (self::method()) {
            'GET' => $_GET,
            'POST', 'PUT', 'DELETE' => $json,
            default => [],
        };
    }

    public static function query($key = null, $default = null)
    {
        return $key ? ($_GET[$key] ?? $default) : $_GET;
    }

    public static function post($key = null, $default = null)
    {
        return $key ? ($_POST[$key] ?? $default) : $_POST;
    }

    /**
     * @throws JsonException
     */
    public static function json($key = null, $default = null)
    {
        $json = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR) ?? [];

        return $key ? ($json[$key] ?? $default) : $json;
    }
}
