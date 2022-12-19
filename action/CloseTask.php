<?php

//namespace action;

class CloseTask extends Action {

    function execute(User $user, array $args): void
    {
        $values = $this->validateArgs($user->id, $args);
        // TODO: Implement execute() method.
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        // TODO: Implement validateArgs() method.
        return [];
    }
}