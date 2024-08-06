<?php
declare(strict_types=1);

(new Task())->uncompleted((int)$_POST['id']);
header('Location: /todos');
exit();