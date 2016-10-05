<?php
// Routes
$app->get('/hello/{name}', function ($request, $response, $args) {
	// Sample log message
    $this->logger->info("INFO");
    $this->logger->warning("WARNING");
    $this->logger->error("ERROR");

    $response->write("Hello, " . $args['name']);
    return $response;
});

$app->get('/', function($request, $response) {
	// Sample log message
    $this->logger->info("INFO");

    $response->write("Hello world");
    return $response;
});

$app->get('/todos', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM tasks ORDER BY task");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});