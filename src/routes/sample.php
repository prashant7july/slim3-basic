<?php

//http://localhost:8000/public/hello/prashant
$app->get('/hello/{name}', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("INFO");
    $this->logger->warning("WARNING");
    $this->logger->error("ERROR");

    $response->write("Hello, " . $args['name']);
    return $response;
});

//http://localhost:8000/public/
$app->get('/', function($request, $response) {
    // Sample log message
    $this->logger->info("INFO");

    $response->write("Hello world");
    return $response;
});
