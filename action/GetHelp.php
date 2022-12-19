<?php


class GetHelp extends Action
{

    function execute(User $user, array $args): void
    {
        $this->sendMessage($user->id, HELP_INFORMATION);
        // TODO: Implement execute() method.
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        return [];
    }
}