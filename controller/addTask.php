<?php
declare(strict_types=1);

(new Task())->add($_POST['text']);
header('Location: /todos');
exit();