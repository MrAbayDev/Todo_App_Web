<?php
require 'vendor/autoload.php';
require 'src/Bot.php';

$token = $_ENV['TELEGRAM_TOKEN'];
$bot = new Bot($token);
$user = new User();
$update = json_decode(file_get_contents('php://input'), true);

if (isset($update['message'])) {
    $message = $update['message'];
    $chatId = $message['chat']['id'];
    $text = $message['text'] ?? null;

    $user->saveTelegramUsers($chatId);
    if ($text === '/start') {
        $bot->handleStartCommand($chatId);
    } elseif ($text === '/add') {
        $bot->addHandlerCommand($chatId);
    } elseif ($text !== null) {
        $bot->addTask($text, $chatId);
    } else {
        echo "Task text is required.";
    }
} elseif (isset($update['callback_query'])) {
    $bot->handleCallbackQuery($update['callback_query']);
}
