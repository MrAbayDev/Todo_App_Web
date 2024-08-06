<?php
declare(strict_types=1);
var_dump($_POST);
(new Task())->complete((int)$_POST['id']);
header('Location: /todos');
exit();