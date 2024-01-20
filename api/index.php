<?php

declare(strict_types=1);

require dirname(__DIR__) . "/vendor/autoload.php";

set_error_handler('ErrorHandler::handleError');
set_exception_handler('ErrorHandler::handleException');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$parts = explode("/", $path);
$resource = $parts[2];
$id = $parts[3] ?? null;

if ($resource != 'tasks') {
    http_response_code(404);
    exit;
}

if (empty($_SERVER["HTTP_X_API_KEY"])) {   
    http_response_code(400);
    echo json_encode(["message" => "missing API key"]);
    exit;
}

$api_key = $_SERVER["HTTP_X_API_KEY"];
$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);
$userGateway = new UserGateway($database);

if ($userGateway->getByAPIKey($api_key) === false) {
    http_response_code(401);
    echo json_encode(["message" => "invalid API key"]);
    exit;
}

header("Content-type: application/json; charset=UTF-8");

$taskGateway = new TaskGateway($database);
$controller = new TaskController($taskGateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);