<?php

declare(strict_types=1);

$router = new Router();

if ($router->isApiCall()) {
    require 'routes/api.php';
    return;
}

if ($router->isTelegramUpdate()) {
    require 'routes/Telegram.php';
    return;
}

require 'routes/web.php';
