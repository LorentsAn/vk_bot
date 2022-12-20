<?php

class DeleteTask extends Action
{

    function execute(User $user, array $args): void
    {
        $values = $this->validateArgs($user->id, $args);
        if ($values == null) {
            $this->sendMessage($user->id, ERROR_OCCURRED);
            return;
        }

        $helper = new Task(0, $user->id, $values[NAME], "", "", $user->getConnection());
        $task_array = $helper->getByName();

        if (count($task_array) == 0) {
            $this->sendMessage($user->id, TASK_WITH_NAME_NOT_EXIST);
            return;
        }
        $task = $this->getTask($user, $task_array);
        $task->deleteTask();
        $this->sendMessage($user->id, INFORMATION_ABOUT_CLOSE_FAIL_TASK);
        // TODO: Implement execute() method.
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        if (count($args) < MIN_LEN_ARGS_CLOSE_TASK) {
            $this->sendMessage($user_id, FEW_ARGUMENTS_FOR_DELETE_TASK);
            return null;
        }
        $res = null;
        foreach ($args as $arg) {
            if ($arg == null) {
                continue;
            }
            $arg_type = trim(explode("=", $arg)[0]);
            $value = trim(str_replace("'", "", explode("=", $arg)[1]));
            $value = str_replace("\"", "", $value);
            if ($arg_type == NAME) {
                if ($value == null) {
                    $this->sendMessage($user_id, EMPTY_NAME_OF_TASK);
                    return null;
                }
                $res[$arg_type] = "'".$value."'";
                break;
            }
        }
        if (!$this->validateNecessaryFields($res)) {
            $this->sendMessage($user_id, NO_REQUIRED_FIELDS_FOR_DELETE_TASK);
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