<?php
declare(strict_types=1);



class Task
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function add(string $task): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (text, status) VALUES (:text, 0)");
        $stmt->execute(['text' => $task]);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM tasks');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function complete(int $id): bool
    {
        $stmt = $this->pdo->prepare("UPDATE tasks SET status = 1 WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function uncompleted(int $id): bool
    {
        $stmt = $this->pdo->prepare("UPDATE tasks SET status = 0 WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
