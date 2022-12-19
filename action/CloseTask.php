<?php

//namespace action;

class CloseTask extends Action {

    function execute(User $user, array $args): void
    {
        $values = $this->validateArgs($user->id, $args);
        if ($values == null) {
            $this->sendMessage($user->id, ERROR_OCCURRED);
            return;
        }
        $values = $this->createDefaultValues($values);
        $helper = new Task(0, $user->id, $values[NAME], "", "", $user->getConnection());
        $task_array = $helper->getByName();

        if (count($task_array) == 0) {
            $this->sendMessage($user->id, TASK_WITH_NAME_NOT_EXIST);
            return;
        }
        $task = $this->getTask($user, $task_array);

        if ($values[IS_COMPLETED] == YES  || $values[IS_COMPLETED] == SHORT_YES) {
            $task->is_completed = true;
            $task->updateCompletion();
            $user->updateBalance($task->cost);
        } else {
            $task->deleteTask();
            $user->updateBalance(-$task->cost);
        }
    }
    private function getTask(User $user, array $task_array): Task {
        $task = $task_array[0];
        if (!$task['task']) {
            $task['task'] = "''";
        }
        return new Task($task['id'], $task['user_id'], "'".trim($task['task_name'])."'", $task['completed_date'], $task['task'], $user->getConnection(), $task['cost'], $task['is_completed']);
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        if (!$this->validateLenArgs($user_id, count($args))) {
            return null;
        }
        $res = [];
        foreach ($args as $arg) {
            if ($arg == null) {
                continue;
            }
            $arg_type = trim(explode("=", $arg)[0]);
            $value = trim(str_replace("'", "", explode("=", $arg)[1]));
            $value = str_replace("\"", "", $value);
            switch ($arg_type) {
                case NAME:
                    if ($value == null) {
                        $this->sendMessage($user_id, EMPTY_NAME_OF_TASK);
                        return null;
                    }
                    $value = "'".$value."'";
                    break;
                case IS_COMPLETED:
                    if ($value == null) {
                        $this->sendMessage($user_id, EMPTY_IS_COMPLETED_FIELD);
                        return null;
                    }
                    $value= $this->validateAnswer($user_id, $value);
                    if (!$value) {
                        return null;
                    }
                    break;
            }
            $res[$arg_type] = $value;
        }
        if (!$this->validateNecessaryFields($res)) {
            $this->sendMessage($user_id, NO_REQUIRED_FIELDS_FOR_CLOSE_TASK);
            return null;
        }
        return $res;
    }

    private function validateAnswer(int $user_id, string $answer): ?string {
        $answer = strtolower($answer);
        if ($answer == YES || $answer == NO || $answer == SHORT_YES || $answer == SHORT_NO) {
            return $answer;
        }
        $this->sendMessage($user_id, WRONG_IS_COMPLETED_ANSWER);
        return null;
    }

    private function validateLenArgs(int $user_id, int $len): bool {
        if ($len < MIN_LEN_ARGS_CLOSE_TASK) {
            $this->sendMessage($user_id, FEW_ARGUMENTS_FOR_CLOSE_TASK);
            return false;
        }
        if ($len > MAX_LEN_ARGS_CLOSE_TASK) {
            $this->sendMessage($user_id, A_LOT_ARGUMENTS_FOR_CLOSE_TASK);
        }
        return true;
    }

    private function validateNecessaryFields(array $res): bool
    {
        if ($res[NAME] != null) {
            return true;
        }
        return false;
    }

    private function createDefaultValues(array $values): array
    {
        if ($values[IS_COMPLETED] == null) {
            $values[IS_COMPLETED] = YES;
        }
        return $values;
    }
}