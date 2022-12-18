<?php

//namespace action;


class MakeTask extends Action
{

    function execute(User $user, array $args): void
    {
        $values = $this->validateArgs($user->id, $args);
        if ($values == null) {
            $this->sendMessage($user->id, ERROR_OCCURRED);
            return;
        }
        $values = $this->createDefaultValues($values);
        $task = new Task($this->createId(), $user->id, $values[NAME], $values[DATE], $values[TASK], $user->getConnection(), $values[COST]);

        if ($task->createTask()) {
            $this->sendMessage($user->id, $task->toString());
        } else {
            $this->sendMessage($user->id, ERROR_OCCURRED);
        }
    }

    private function createId(): int
    {
        $m = microtime(true);
        return floor(($m - floor($m)) * 100000000);
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        $res = [];
        if (count($args) < 2) {
            $this->sendMessage($user_id, FEW_ARGUMENTS_FOR_MAKE_TASK);
            return null;
        }
        foreach ($args as $arg) {
            if ($arg == null) {
                continue;
            }
            $arg_type = trim(explode("=", $arg)[0]);
            $value = str_replace("'", "", explode("=", $arg)[1]);
            switch ($arg_type) {
                case NAME:
                    if ($value == null) {
                        $this->sendMessage($user_id, EMPTY_NAME_OF_TASK);
                        return null;
                    }
                    break;
                case DATE:
                    if ($value == null) {
                        $this->sendMessage($user_id, EMPTY_FINISH_DATE);
                        return null;
                    }
                    if (!$this->validateDate($value)) {
                        $this->sendMessage($user_id, WRONG_DATA);
                        return null;
                    }
                    break;
                case COST:
                    if ($value != null) {
                        if (!is_numeric($value)) {
                            $this->sendMessage($user_id, ENTERED_PRICE_NOT_NUMBER);
                            return null;
                        }
                    }
            }
            $res[$arg_type] = $value;
        }
        if (!$this->validateNecessaryFields($res)) {
            $this->sendMessage($user_id, NO_REQUIRED_FIELDS_FOR_MAKE_TASK);
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
            $values[TASK] = "";
        }
        if (!$values[COST]) {
            $values[COST] = 10;
        }
          return $values;
    }
}
