<?php

require_once 'config.php';
require_once 'bot/bot.php';
require_once 'global.php';

require_once 'resourses/action_types.php';
require_once 'resourses/arg_types.php';
require_once 'resourses/strings.php';
require_once 'db/Database.php';

require_once 'Entity/User.php';
require_once 'Entity/Task.php';

require_once 'action/Action.php';
require_once 'action/CloseTask.php';
require_once 'action/GetScore.php';
require_once 'action/MakeTask.php';
require_once 'action/GetAllTasks.php';
require_once 'action/ActionStorage.php';

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
//    $message_text = $data->object->text;
//    $chat_id = $data->object->peer_id;
//    if($message_text){
//        bot_sendMessage($chat_id, $message_text, VK_API_ACCESS_TOKEN);
//    }
//    exit('ok');
    $handler = new MessageHandler();
    $response = $handler->process_message($data);
//    if ($response == 'ok') {
//        _callback_okResponse();
//    } else {
//        _callback_response($response);
//    }
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
