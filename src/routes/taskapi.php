<?php
//get all todos - http://localhost:8000/public/todos
$app->get('/todos', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM tasks ORDER BY task");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});


// Retrieve todo with id - http://localhost:8000/public/todos/1
$app->get('/todo/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM tasks WHERE id =:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $todos = $sth->fetchObject();
    return $this->response->withJson($todos);
});

// Search for todo with given search teram in their name - http://localhost:8000/public/todos/search/bug
$app->get('/todos/search/[{query}]', function ($request, $response, $args) {
     $sth = $this->db->prepare("SELECT * FROM tasks WHERE UPPER(task) LIKE :query ORDER BY task");
    $query = "%".$args['query']."%";
    $sth->bindParam("query", $query);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// Add a new todo - http://localhost:8000/public/todo  
$app->post('/todo', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO tasks (task) VALUES (:task)";
     $sth = $this->db->prepare($sql);
    $sth->bindParam("task", $input['task']);
    $sth->execute();
    $input['id'] = $this->db->lastInsertId();
    return $this->response->withJson($input);
});

// DELETE a todo with given id - http://localhost:8000/public/todo/{id}
$app->delete('/todo/[{id}]', function ($request, $response, $args) {
     $sth = $this->db->prepare("DELETE FROM tasks WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// Update todo with given id - http://localhost:8000/public/todo/{id}
$app->put('/todo/[{id}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sql = "UPDATE tasks SET task=:task WHERE id=:id";
     $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $args['id']);
    $sth->bindParam("task", $input['task']);
    $sth->execute();
    $input['id'] = $args['id'];
    return $this->response->withJson($input);
});
