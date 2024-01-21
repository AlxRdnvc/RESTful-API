<?php

declare(strict_types=1);

require __DIR__ . "/bootstrap.php";

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$parts = explode("/", $path);
$resource = $parts[2];
$id = $parts[3] ?? null;

if ($resource != 'tasks') {
    http_response_code(404);
    exit;
}

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);
$userGateway = new UserGateway($database);
$auth = new Auth($userGateway);
if (!$auth->authenticateAPIKey()) {
    exit;
}
$user_id = $auth->getuser_id();
$taskGateway = new TaskGateway($database);
$controller = new TaskController($taskGateway, $user_id);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);