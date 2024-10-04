<?php

namespace App\Http;

use JsonException;

class Response
{
    /**
     * @throws JsonException
     */
    public static function json(array $data = [], int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_THROW_ON_ERROR);

        exit;
    }
}
