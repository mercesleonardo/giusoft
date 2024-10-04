<?php

require '../vendor/autoload.php';

use App\Core\Route;

Route::loadRoutesFromFile('../routes/api.php');

try {
    Route::resolve();
} catch (JsonException $e) {
    error_log($e->getMessage());
    echo json_encode(['error' => 'Internal Server Error'], JSON_THROW_ON_ERROR);
}
