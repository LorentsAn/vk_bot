<?php

//namespace action;

abstract class Action
{
    public function sendMessage(int $user_id, string $message): void
    {
        bot_sendMessage($user_id, $message, VK_API_ACCESS_TOKEN);
    }

    protected function getTask(User $user, array $task_array): Task {
        $task = $task_array[0];
        if (!$task[TASK]) {
            $task[TASK] = "''";
        }
        return new Task($task[_ID], $task[USER_ID], "'".trim($task[TASK_NAME])."'", $task[COMPLETED_DATE], $task[TASK], $user->getConnection(), $task[COST], $task[IS_COMPLETED]);
    }

    abstract function execute(User $user, array $args): void;

    abstract function validateArgs(int $user_id, array $args): ?array;
}