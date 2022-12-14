<?php

//namespace action;


class MakeTask extends Action
{

    function execute(User $user, array $args, int $group_id): void
    {
        $values = $this->validateArgs($group_id, $args);
        if ($values == null) {
            $this->sendMessage($group_id, ERROR_OCCURRED);
            return;
        }
        $values = $this->createDefaultValues($values);
        $task = new Task($this->createId(), $user->id, $group_id, $values[NAME], $values[DATE], $values[TASK], $user->getConnection(), $values[COST]);

        if (count($task->getByName()) != 0) {
            $this->sendMessage($group_id, TASK_WITH_NAME_ALREADY_EXIST);
            return;
        }
        if ($task->createTask()) {
            $this->sendMessage($group_id, $task->toString());
        } else {
            $this->sendMessage($group_id, ERROR_OCCURRED);
        }
    }

    private function createId(): int
    {
        $m = microtime(true);
        return floor(($m - floor($m)) * 100000000);
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
                case DATE:
                    if ($value == null) {
                        $this->sendMessage($group_id, EMPTY_FINISH_DATE);
                        return null;
                    }
                    if (!$this->validateDate($value)) {
                        $this->sendMessage($group_id, WRONG_DATE);
                        return null;
                    }
                    $value = "'".$value."'";
                    break;
                case COST:
                    if ($value != null) {
                        if (!is_numeric($value)) {
                            $this->sendMessage($group_id, ENTERED_PRICE_NOT_NUMBER);
                            return null;
                        }
                        if ($value > MAX_COST_FOR_TASK) {
                            $this->sendMessage($group_id, TOO_BIG_COST);
                            $value = MAX_COST_FOR_TASK;
                        }
                    }
            }
            $res[$arg_type] = $value;
        }
        if (!$this->validateNecessaryFields($res)) {
            $this->sendMessage($group_id, NO_REQUIRED_FIELDS_FOR_MAKE_TASK);
            return null;
        }
        return $res;
    }


    private function validateDate(string $str): bool
    {
        return strtotime($str) > strtotime("now");
    }

    private function validateNecessaryFields(array $arr): bool {
        if ($arr[NAME] != null && $arr[DATE] != null) {
            return true;
        }
        return false;
    }

    private function createDefaultValues(array $values): array
    {
        if (!$values[TASK]) {
            $values[TASK] = "''";
        }
        if (!$values[COST]) {
            $values[COST] = 10;
        }
          return $values;
    }

    private function validateLenArgs(int $user_id, int $len): bool {
        if ($len < MIN_LEN_ARGS_MAKE_TASK) {
            $this->sendMessage($user_id, FEW_ARGUMENTS_FOR_MAKE_TASK);
            return false;
        }
        if ($len > MAX_LEN_ARGS_MAKE_TASK) {
            $this->sendMessage($user_id, A_LOT_ARGUMENTS_FOR_MAKE_TASK);
        }
        return true;
    }
}
