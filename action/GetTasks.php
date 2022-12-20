<?php

class GetTasks extends Action
{
    function execute(User $user, array $args): void
    {
        $values = $this->validateArgs($user->id, $args);
        $values = $this->createDefaultValues($values);

        $empty_task = new Task(0, $user->id, "", "", "", $user->getConnection(), 0);
        $result = $empty_task->getByUser();
        if (count($result) == 0) {
            $this->sendMessage($user->id, THIS_USER_DOES_NOT_HAVE_TASK);
            return;
        }
        $output_string = HEADER_GET_TASK_COMMAND;
        foreach ($result as $task) {
            if (strlen($output_string) > MAX_MESSAGE_LEN) {
                $this->sendMessage($user->id, $output_string);
                $output_string = "";
            }
            $output_string = $output_string . $this->chooseTask($values[FLAG], $task);
        }
        $this->sendMessage($user->id, $output_string);
    }

    private function chooseTask(string $flag, array $task): string {
        if ($flag == "'w'") {
            $completed_day = $task[COMPLETED_DATE];
            if (strtotime($completed_day) < strtotime("next Monday")
                && strtotime($completed_day) >= strtotime("last Monday")) {
                return $this->toString($task);
            }
        } else if ($flag == "'a'") {
            return $this->toString($task);
        } else {
            $is_completed = $task[IS_COMPLETED];
            if (!$is_completed) {
                return $this->toString($task);
            }
        }
        return "";
}

    private function toString(array $task): string {
        $task_name = $task[TASK_NAME];
        $completed_day = $task[COMPLETED_DATE];
        $cost = $task[COST];
        $is_completed = $task[IS_COMPLETED];
        $fail = $task[FAIL];
        if ($is_completed) {
            if ($fail) {
                return sprintf(INFORMATION_ABOUT_FAIL_TASK, $task_name, $completed_day, $cost);
            }
            return sprintf(INFORMATION_ABOUT_COMPLETED_TASK, $task_name, $completed_day, $cost);
        }
        return  sprintf(INFORMATION_ABOUT_NOT_COMPLETED_TASK, $task_name,  $completed_day, $cost);
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        $res = null;
        foreach ($args as $arg) {
            if ($arg == null) {
                continue;
            }
            $arg_type = trim(explode("=", $arg)[0]);
            $value = trim(str_replace("'", "", explode("=", $arg)[1]));
            $value = str_replace("\"", "", $value);
            $value = str_replace(",", "", $value);
            if ($arg_type == FLAG) {
                if ($value == null) {
                    $this->sendMessage($user_id, EMPTY_FLAG);
                    return null;
                }
                $res[FLAG] = "'".$value."'";
            }
        }
        // TODO: Implement validateArgs() method.
        return $res;
    }

    private function createDefaultValues(array $values): array
    {
        if ($values[FLAG] == null) {
            $values[FLAG] = "'c'";
        }
        return $values;
    }
}