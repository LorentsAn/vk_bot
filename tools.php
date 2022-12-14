<?php

require_once 'db/request_db.php';

function process_message(User $user, string $message): string {
    $result = "";

    switch ($message) {
        case 'create promise':
            break;
        case 'get promises':
            break;
        case 'close promise':
            break;
        case 'get score':
            break;
        case 'get tor users':
            break;
    }
    return $result;
}
