<?php


class GetScore extends Action {

    function execute(User $user, array $args): void
    {
        $output_message = sprintf(INFORMATION_ABOUT_BALANCE, $user->getBalance());
        $this->sendMessage($user->id, $output_message);
        // TODO: Implement execute() method.
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        return null;
    }
}