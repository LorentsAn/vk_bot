<?php

namespace action;

use db\Database;

class GetScore extends Action {

    function execute(int $user_id, array $args): void
    {
        $db = new Database();
        $connection = $db->getConnection();

        $user = new \User($user_id, $connection);
        if (!$user->existUser()) {
            $user->createUser();
        }


        // TODO: Implement execute() method.
    }

    function validateArgs(int $user_id, array $args): ?array
    {
        // TODO: Implement validateArgs() method.
        return [];
    }
}