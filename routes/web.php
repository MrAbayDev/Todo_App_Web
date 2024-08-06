<?php

declare(strict_types=1);
Router::get('/', fn() => require 'view/pages/home.php');

Router::get('/todos', fn() => require 'view/pages/todos.php');

Router::post('/todos', fn() => require 'controller/addTask.php');
Router::get('/delete', fn() => require 'controller/deleteTask.php');
Router::post('/complete', fn() => require 'controller/completeTask.php');
(new Router)->post('/uncomplete', fn() => require 'controller/uncompleteTask.php');

//(new Router)->post('/todos', function() {
//    $task = new Task();
//    $task->add($_POST['text']);
//    header('Location: /todos');
//    exit();
//});
//
//(new Router)->post('/complete', function() {
//    $task = new Task();
//    $task->complete($_POST['id']);
//    header('Location: /todos');
//    exit();
//});
//
//(new Router)->post('/uncomplete', function() {
//    $task = new Task();
//    $task->uncompleted($_POST['id']);
//    header('Location: /todos');
//    exit();
//});

//(new Router)->post('/delete', function() {
//    $task = new Task();
//    $task->delete((int)$_POST['id']);
//    header('Location: /todos');
//    exit();
//});

Router::get('/notes', fn() => require 'view/pages/notes.php');
Router::get('/login', fn() => require 'view/pages/auth/login.php');
Router::get('/register', fn() => require 'view/pages/auth/resgister.php');
Router::post('/login', fn() => (new User())->login());
Router::get('/logout', fn() => (new User())->logout());
Router::post('/register', fn() => (new User())->register());
