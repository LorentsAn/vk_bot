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
            $output_string = $output_string . $this->toString($task);
        }
        $this->sendMessage($user->id, $output_string);
        return;
    }

    private function toString(array $task): string {
        $task_name = $task[TASK_NAME];
        $completed_day = $task[COMPLETED_DATE];
        $task_description = $task[TASK];
        $cost = $task[COST];
        $is_completed = $task[IS_COMPLETED];

        if ($is_completed) {
            return sprintf(INFORMATION_ABOUT_COMPLETED_TASK, $task_name, $task_description, $completed_day, $cost);
        }
        return  sprintf(INFORMATION_ABOUT_NOT_COMPLETED_TASK, $task_name, $task_description, $completed_day, $cost);
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        // TODO: Implement validateArgs() method.
        return [];
    }
}