<?php

class DeleteTask extends Action
{
    function execute(User $user, array $args, int $group_id): void
    {
        $values = $this->validateArgs($group_id, $args);
        if ($values == null) {
            $this->sendMessage($group_id, ERROR_OCCURRED);
            return;
        }

        $helper = new Task(0, $user->id, $group_id, $values[NAME], "", "", $user->getConnection());
        $task_array = $helper->getByName();

        if (count($task_array) == 0) {
            $this->sendMessage($group_id, TASK_WITH_NAME_NOT_EXIST);
            return;
        }
        $task = $this->getTask($user, $group_id, $task_array);
        $task->deleteTask();
        $this->sendMessage($group_id, INFORMATION_ABOUT_DELETE_TASK);
        // TODO: Implement execute() method.
    }

    function validateArgs(int $group_id, array $args): ?array
    {
        if (count($args) < MIN_LEN_ARGS_CLOSE_TASK) {
            $this->sendMessage($group_id, FEW_ARGUMENTS_FOR_DELETE_TASK);
            return null;
        }
        $res = null;
        foreach ($args as $arg) {
            if ($arg == null) {
                continue;
            }

            $commandAndArg = $this->getCommandAndArguments($arg);
            $arg_type = $commandAndArg[COMMAND];
            $value = $commandAndArg[ARGUMENTS];

            if ($arg_type == NAME) {
                if ($value == null) {
                    $this->sendMessage($group_id, EMPTY_NAME_OF_TASK);
                    return null;
                }
                $res[$arg_type] = "'".$value."'";
                break;
            }
        }
        if (!$this->validateNecessaryFields($res)) {
            $this->sendMessage($group_id, NO_REQUIRED_FIELDS_FOR_DELETE_TASK);
            return null;
        }
        return $res;
        // TODO: Implement validateArgs() method.
    }

    private function validateNecessaryFields(array $res): bool
    {
        if ($res[NAME] != null) {
            return true;
        }
        return false;
    }
}