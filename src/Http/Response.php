<?php

namespace App\Http;

use JsonException;

class Response
{
    /**
     * This function sends a JSON response with the provided data and status code.
     *
     * @param array $data The data to be sent in the JSON response. Default is an empty array.
     * @param int $status The HTTP status code for the response. Default is 200 (OK).
     *
     * @throws JsonException If the JSON encoding fails due to invalid data.
     *
     * @return void The function does not return any value. It outputs the JSON response and exits the script.
     */
    public static function json(array $data = [], int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_THROW_ON_ERROR);

        exit;
    }
}
