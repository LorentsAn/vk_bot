<?php

namespace action;

abstract class Action
{
    public function sendMessage(int $user_id, string $message): void
    {
        bot_sendMessage($user_id, $message, VK_API_ACCESS_TOKEN);
    }

    abstract function execute(int $user_id, array $args): void;

    abstract function validateArgs(int $user_id, array $args): ?array;
}