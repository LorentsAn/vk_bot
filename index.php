<?php

require_once 'config.php';
require_once 'bot/bot.php';
require_once 'global.php';

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
                exit('ok');
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
//    echo 'ok';
    $handler = new MessageHandler();
    $response = $handler->process_message($data);
    if ($response == 'ok') {
        _callback_okResponse();
    } else {
        _callback_response($response);
    }

}

function _callback_okResponse() {
    log_msg("Hello, log!");
    _callback_response('ok');
}

function _callback_response($data) {
    echo $data;
    exit();
}
