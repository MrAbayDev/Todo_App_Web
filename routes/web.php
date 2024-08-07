<?php

declare(strict_types=1);
Router::get('/', fn() => require 'view/pages/home.php');

Router::get('/todos', fn() => require 'view/pages/todos.php');

Router::post('/todos', fn() => require 'controller/addTask.php');
Router::get('/delete', fn() => require 'controller/deleteTask.php');
Router::post('/complete', fn() => require 'controller/completeTask.php');
Router::post('/uncomplete', fn() => require 'controller/uncompleteTask.php');

Router::get('/notes', fn() => require 'view/pages/notes.php');

Router::get('/login', fn() => require 'view/pages/auth/login.php');
Router::post('/login', fn() => (new User())->login());

Router::get('/register', fn() => require 'view/pages/auth/resgister.php');
Router::post('/register', fn() => (new User())->register());

Router::get('/logout', fn() => (new User())->logout());
