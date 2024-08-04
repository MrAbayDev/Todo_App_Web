<?php
declare(strict_types=1);

namespace Abdulqayum\TodoApp;

use GuzzleHttp\Client;
use PDO;

class Bot
{

    private string $api;
    public Client $http;
    private PDO   $pdo;
    public function __construct(string $token)
    {
        $this->api = "https://api.telegram.org/bot{$token}/";
        $this->http = new Client(['base_uri' => $this->api]);

        $this->pdo  = DB::connect();
    }

    public function handleStartCommand(int $chatId): void
    {
        $this->sendMessage($chatId, 'Xush Kelibsiz Todo Listga');
    }

    public function addHandlerCommand(int $chatId): void
    {
        $keyboard = [
            'inline_keyboard' => [
                [['text' => 'Get Tasks', 'callback_data' => 'get_tasks']]
            ]
        ];
        $replyMarkup = json_encode($keyboard);
        $this->sendMessage($chatId, "taskingizni kiriting:", $replyMarkup);
    }

    public function addTask(string $text, int $chatId): void
    {
        $task = new Task();
        $task->add($text);
        $this->sendMessage($chatId, "Yangi task qoshildi: $text");
    }

    public function getTask(int $chatId): void
    {
        $this->sendTaskList($chatId, "Tasklar:", true);
    }

    public function checkTask(int $taskId): void
    {
        $task = new Task();
        $task->complete($taskId, 1);
    }

    public function unCheckTask(int $taskId): void
    {
        $task = new Task();
        $task->uncompleted($taskId, 0);
    }

    public function handleCallbackQuery(array $callbackQuery): void
    {
        $chatId = $callbackQuery['message']['chat']['id'];
        $callbackData = $callbackQuery['data'];

        if (strpos($callbackData, 'check_task_') === 0) {
            $taskId = (int)str_replace('check_task_', '', $callbackData);
            $this->checkTask($taskId);
            $this->sendTaskList($chatId, "Task $taskId check qilindi ", true);
        } elseif (strpos($callbackData, 'uncheck_task_') === 0) {
            $taskId = (int)str_replace('uncheck_task_', '', $callbackData);
            $this->unCheckTask($taskId);
            $this->sendTaskList($chatId, "Task $taskId uncheck qilindi ", true);
        } elseif ($callbackData === 'get_tasks') {
            $this->getTask($chatId);
        } elseif (strpos($callbackData, 'delete_task_') === 0) {
            $taskId = (int)str_replace('delete_task_', '', $callbackData);
            $this->deleteTask($taskId, $chatId);
            $this->sendTaskList($chatId, "Task $taskId o'chirildi", true);
        }
    }

    private function sendTaskList(int $chatId, string $message, bool $includeCheckboxes): void
    {
        $task = new Task();
        $tasks = $task->getAll();

        $text = '';
        $count = 1;
        $keyboard = ['inline_keyboard' => []];
        foreach ($tasks as $task) {
            $buttonText = $task['status'] ? "$count" : "$count";
            $callbackData = $task['status'] ? "uncheck_task_{$task['id']}" : "check_task_{$task['id']}";

            $text .= $count . ". " . ($task['status'] ? "<del>" . $task['text'] . "</del>" : $task['text']) . "\n";
            $keyboard['inline_keyboard'][] = [
                ['text' => $buttonText, 'callback_data' => $callbackData]
            ];
            if ($includeCheckboxes) {
                $keyboard['inline_keyboard'][] = [
                    ['text' => "delete task", 'callback_data' => "delete_task_{$task['id']}"]
                ];
            }
            $count++;
        }

        $replyMarkup = json_encode($keyboard);
        $text = !empty($text) ? $text : 'No tasks available.';
        $this->sendMessage($chatId, $message . "\n" . $text, $replyMarkup);
    }

    public function deleteTask(int $taskId, int $chatId): void
    {
        $task = new Task();
        $task->delete($taskId);
        $this->sendMessage($chatId, "Task $taskId o'chirildi.");
    }

    public function sendMessage(int $chatId, string $text, ?string $replyMarkup = null): void
    {
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ];
        if ($replyMarkup) {
            $data['reply_markup'] = $replyMarkup;
        }

        try {
            $this->http->post('sendMessage', ['json' => $data]);
        } catch (\Exception $e) {
            error_log("Failed to send message: " . $e->getMessage());
        }
    }
}
