<?php

require_once 'config.php';
require_once 'bot/bot.php';
require_once 'global.php';

require_once 'resources/action_types.php';
require_once 'resources/arg_types.php';
require_once 'resources/strings.php';
require_once 'resources/numbers.php';
require_once 'db/Database.php';

require_once 'entity/User.php';
require_once 'entity/Task.php';

require_once 'action/Action.php';
require_once 'action/CloseTask.php';
require_once 'action/GetScore.php';
require_once 'action/MakeTask.php';
require_once 'action/GetTasks.php';
require_once 'action/DeleteTask.php';
require_once 'action/ActionStorage.php';
require_once 'action/GetHelp.php';

require_once 'MessageHandler.php';

index();

function index() {
    $data = _callback_getEvent();
    $user_id = $data->object->user_id;
    //$user = get_user($user_id);
    try {
        switch ($data->type) {
            case 'confirmation':
                _callback_handleConfirmation();
                break;

            case 'message_new':
                _callback_handleMessageNew($data);
                break;
        }
    } catch (Exception $e) {
        log_error($e);
    }

}

function _callback_getEvent() {
    return json_decode(file_get_contents('php://input'));
}

function _callback_handleConfirmation() {
    _callback_response(CALLBACK_API_CONFIRMATION_TOKEN);
}

function _callback_handleMessageNew($data) {
    $handler = new MessageHandler();
    $response = $handler->process_message($data);
    echo "ok";

}

function _callback_okResponse() {
    log_msg("Hello, log!");
    _callback_response('ok');
}

function _callback_response($data) {
    echo $data;
    exit();
}
