<?php
declare(strict_types=1);


class User {
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function register(): void
    {
        if (isset($_POST['email'], $_POST['password'])) {
            if ($this->isUserExist()) {
                echo "user already exist";
            } else {
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $stmt = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $result = $stmt->execute();

                if ($result) {
                    header('Location: /');
                } else {
                    echo 'Something went wrong';
                }
            }
        }
    }
    public function login(): void
    {
        if (isset($_POST['email'], $_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $email;
                header('Location: /');
            } else {
                echo "Something went wrong";
            }
        }
    }
    public function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: /');
        exit();
    }
    public function saveTelegramUsers(int $chatId): void
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE chat_id = :chat_id");
        $stmt->bindParam(':chat_id', $chatId, PDO::PARAM_INT);
        $stmt->execute();
        if (!$stmt->fetch()) {
            $stmt = $this->pdo->prepare("INSERT INTO users (chat_id) VALUES (:chat_id)");
            $stmt->bindParam(':chat_id', $chatId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    public function isUserExist(): bool
    {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return (bool)$stmt->fetch();
        }
        return false;
    }
    public function updateChatIdByEmail(string $email, int $chatId): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET chat_id = :chat_id WHERE email = :email");
        $stmt->bindParam(':chat_id', $chatId, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }
}
?>