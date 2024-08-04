<?php

use Abdulqayum\TodoApp\Task;

$router = new Router();

$router->get('/', fn() => require 'view/pages/home.php');

$router->get('/todos', fn() => require 'view/pages/todos.php');

$router->post('/todos', function() {
    $task = new Task();
    $task->add($_POST['text']);
    header('Location: /todos');
    exit();
});

$router->post('/complete', function() {
    $task = new Task();
    $task->complete($_POST['id']);
    header('Location: /todos');
    exit();
});

$router->post('/uncomplete', function() {
    $task = new Task();
    $task->uncompleted($_POST['id']);
    header('Location: /todos');
    exit();
});

$router->get('/delete', function() {
    $task = new Task();
    $task->delete((int)$_GET['id']);
    header('Location: /todos');
    exit();
});

$router->get('/notes', fn() => require 'view/pages/notes.php');

$router->get('/login', fn() => require 'view/pages/auth/login.php');

$router->get('/register', fn() => require 'view/pages/auth/resgister.php');

$router->post('/login', fn() => (new \Abdulqayum\TodoApp\User())->login());

$router->get('/logout', fn() => (new \Abdulqayum\TodoApp\User())->logout());

$router->post('/register', fn() => (new \Abdulqayum\TodoApp\User())->register());