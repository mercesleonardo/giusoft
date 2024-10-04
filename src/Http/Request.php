<?php

namespace App\Http;

use JsonException;

class Request
{
    /**
     * Returns the request method.
     *
     * @return string The request method (e.g., GET, POST, PUT, DELETE).
     */
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Returns the request body.
     *
     * @throws JsonException If the JSON decoding fails.
     * @return array|mixed The request body. If the request method is GET, returns $_GET.
     *                     For POST, PUT, DELETE methods, returns the decoded JSON input.
     *                     If the input is not valid JSON, returns an empty array.
     */
    public static function body(): mixed
    {
        $json = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR) ?? [];

        return match (self::method()) {
            'GET' => $_GET,
            'POST', 'PUT', 'DELETE' => $json,
            default => [],
        };
    }

    /**
     * Returns a specific query parameter or all query parameters.
     *
     * @param string|null $key The key of the query parameter to return. If null, returns all query parameters.
     * @param mixed|null $default The default value to return if the specified key is not found.
     * @return mixed|array The value of the specified query parameter or all query parameters.
     */
    public static function query(string $key = null, mixed $default = null): mixed
    {
        return $key ? ($_GET[$key] ?? $default) : $_GET;
    }

    /**
     * Returns a specific POST parameter or all POST parameters.
     *
     * @param string|null $key The key of the POST parameter to return. If null, returns all POST parameters.
     * @param mixed|null $default The default value to return if the specified key is not found.
     * @return mixed|array The value of the specified POST parameter or all POST parameters.
     */
    public static function post(string $key = null, mixed $default = null): mixed
    {
        return $key ? ($_POST[$key] ?? $default) : $_POST;
    }

    /**
     * Returns a specific JSON parameter or all JSON parameters.
     *
     * @param string|null $key The key of the JSON parameter to return. If null, returns all JSON parameters.
     * @param mixed|null $default The default value to return if the specified key is not found.
     * @return mixed|array The value of the specified JSON parameter or all JSON parameters.
     *@throws JsonException If the JSON decoding fails.
     */
    public static function json(string $key = null, mixed $default = null): mixed
    {
        $json = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR) ?? [];

        return $key ? ($json[$key] ?? $default) : $json;
    }
}
