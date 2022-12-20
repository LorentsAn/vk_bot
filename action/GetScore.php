<?php


class GetScore extends Action {

    function execute(User $user, array $args): void
    {
        $balance = $user->getBalance();
        $output_message = sprintf(INFORMATION_ABOUT_BALANCE, $user->getBalance());
        $this->sendMessage($user->id, $output_message);
        // TODO: Implement execute() method.
    }

    function compareBalance(int $user_id, int $balance) {
        if ($balance < 0) {
            $this->sendMessage($user_id, BAD_BALANCE);
        } else if ($balance > 0 && $balance < 100) {
            $this->sendMessage($user_id, NORMAL_BALANCE);
        } else if ($balance > 100 && $balance < 300) {
            $this->sendMessage($user_id, GOOD_BALANCE);
        } else if ($balance > 300) {
            $this->sendMessage($user_id, AWESOME_BALANCE);
        }
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        return null;
    }
}