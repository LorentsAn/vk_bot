<?php

//namespace action;

class CloseTask extends Action {

    function execute(User $user, array $args, int $group_id): void
    {
        $values = $this->validateArgs($group_id, $args);
        if ($values == null) {
            $this->sendMessage($group_id, ERROR_OCCURRED);
            return;
        }
        $values = $this->createDefaultValues($values);
        $helper = new Task(0, $user->id, $group_id, $values[NAME], "", "", $user->getConnection());
        $task_array = $helper->getByName();

        if (count($task_array) == 0) {
            $this->sendMessage($group_id, TASK_WITH_NAME_NOT_EXIST);
            return;
        }
        $task = $this->getTask($user, $group_id,  $task_array);

        $task->is_completed = true;
        $task->updateCompletion();

        if ($values[COMPLETED] == YES  || $values[COMPLETED] == SHORT_YES) {
            $task->updateStatus();
            $user->updateBalance($user->getBalance() + $task->cost);
            $this->sendMessage($group_id, INFORMATION_ABOUT_STATUS);
        } else {
            //$task->deleteTask();
            $user->updateBalance($user->getBalance() - $task->cost);
            $this->sendMessage($group_id, INFORMATION_ABOUT_CLOSE_FAIL_TASK);
        }
        $getScore = new GetScore();
        $getScore->execute($user, [], $group_id);
    }

    function validateArgs(int $group_id, array $args): ?array
    {
        if (!$this->validateLenArgs($group_id, count($args))) {
            return null;
        }
        $res = [];
        foreach ($args as $arg) {
            if ($arg == null) {
                continue;
            }
            $commandAndArg = $this->getCommandAndArguments($arg);
            $arg_type = $commandAndArg[COMMAND];
            $value = $commandAndArg[ARGUMENTS];
            switch ($arg_type) {
                case NAME:
                    if ($value == null) {
                        $this->sendMessage($group_id, EMPTY_NAME_OF_TASK);
                        return null;
                    }
                    $value = "'".$value."'";
                    break;
                case COMPLETED:
                    if ($value == null) {
                        $this->sendMessage($group_id, EMPTY_IS_COMPLETED_FIELD);
                        return null;
                    }
                    $value= $this->validateAnswer($group_id, $value);
                    if (!$value) {
                        return null;
                    }
                    break;
            }
            $res[$arg_type] = $value;
        }
        if (!$this->validateNecessaryFields($res)) {
            $this->sendMessage($group_id, NO_REQUIRED_FIELDS_FOR_CLOSE_TASK);
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
        if ($values[COMPLETED] == null) {
            $values[COMPLETED] = YES;
        }
        return $values;
    }
}