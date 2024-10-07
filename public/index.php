<?php

require '../vendor/autoload.php';
require '../src/helpers.php';

use App\Core\Route;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

Route::loadRoutesFromFile('../routes/api.php');

try {
    Route::resolve();
} catch (JsonException $e) {
    error_log($e->getMessage());
    echo json_encode(['error' => 'Internal Server Error'], JSON_THROW_ON_ERROR);
}
