<?php


class GetAllTasks extends Action
{

    function execute(User $user, array $args): void
    {
        $empty_task = new Task(0, $user->id, "", "", "", $user->getConnection(), 0);
        $result = $empty_task->getByUser();
        if (count($result) == 0) {
            $this->sendMessage($user->id, THIS_USER_DOES_NOT_HAVE_TASK);
            return;
        }
        $output_string = "";
        foreach ($result as $task) {
            $output_string = $output_string . $task->toString();
        }
        $this->sendMessage($user->id, $output_string);
        return;
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        // TODO: Implement validateArgs() method.
        return [];
    }
}