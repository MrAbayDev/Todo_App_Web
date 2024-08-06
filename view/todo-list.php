<?php

declare(strict_types=1);

//use Abdulqayum\TodoApp\Task;

$task     = new Task();
$todoList = $task->getAll();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/c4497f215d.js" crossorigin="anonymous"></script>

<div class="list-group">
    <?php foreach ($todoList as $task): ?>
        <?php
        $checked = $task['status'] ? 'checked' : '';
        $strike = $task['status'] ? 'text-decoration-line-through' : '';
        $action = $task['status'] ? 'uncomplete' : 'complete';
        $taskId = $task['id'];
        ?>
        <div class="d-flex list-group-item">
            <form action="/<?= $action ?>" method="post" class="w-100 d-flex align-items-center">
                <input type="hidden" name="id" value="<?= $taskId ?>">
                <button type="submit" style="display: none;"></button> <!-- Yashirin yuborish tugmasi -->
                <label class="form-check-label <?= $strike ?>" for="task-<?= $taskId ?>">
                    <input type="checkbox" id="task-<?= $taskId ?>" <?= $checked ?> onclick="this.form.submit()" />
                    <?= $task['text'] ?>
                </label>
            </form>
            <form action="/delete" method="get" class="ms-2">
                <input type="hidden" name="id" value="<?= $taskId ?>">
                <button type="submit" class="btn btn-link text-danger"><i class="fa-solid fa-trash"></i></button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
