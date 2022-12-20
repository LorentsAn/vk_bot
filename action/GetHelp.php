<?php


class GetHelp extends Action
{

    function execute(User $user, array $args, int $group_id): void
    {
        $this->sendMessage($group_id, HELP_INFORMATION);
        // TODO: Implement execute() method.
    }

    function validateArgs(int $group_id, array $args): ?array
    {
        return [];
    }
}