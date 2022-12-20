<?php


class GetScore extends Action {

    function execute(User $user, array $args, int $group_id): void
    {
        $balance = $user->getBalance();
        $output_message = sprintf(INFORMATION_ABOUT_BALANCE, $user->getBalance()) . $this->compareBalance($balance);
        $this->sendMessage($group_id, $output_message);
        // TODO: Implement execute() method.
    }

    function compareBalance(int $balance) {
        if ($balance < 0) {
            return BAD_BALANCE;
        } else if ($balance > 0 && $balance < 100) {
            return NORMAL_BALANCE;
        } else if ($balance > 100 && $balance < 300) {
            return GOOD_BALANCE;
        } else if ($balance > 300) {
            return AWESOME_BALANCE;
        }
    }

    function validateArgs(int $group_id, array $args): ?array
    {
        return null;
    }
}