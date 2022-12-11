<?php
require_once 'config.php';
const CALLBACK_API_EVENT_CONFIRMATION = 'confirmation';
const CALLBACK_API_EVENT_MESSAGE_NEW = 'message_new';

callback_handleEvent();

function callback_handleEvent()
{
    $event = json_decode(file_get_contents('php://input'), true);

    try {
        switch ($event['type']) {
            //Подтверждение сервера
            case CALLBACK_API_EVENT_CONFIRMATION:
                _callback_response(CALLBACK_API_CONFIRMATION_TOKEN);
                break;

            //Получение нового сообщения
            case CALLBACK_API_EVENT_MESSAGE_NEW:
                $userId = $event->object->user_id;
                $user_id = $userId;
                $request_params = array(
                    'message' => "Ваше сообщение получено! В ближайшее время админ группы на него ответит.",
                    'user_id' => $userId,
                    'access_token' => VK_API_ACCESS_TOKEN,
                    'v' => '5.131',
                    'random_id' => rand(),
                );
                $get_params = http_build_query($request_params);
                file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
                echo('ok'); // Возвращаем "ok" серверу Callback API
                break;

            default:
                _callback_response('Unsupported event');
                break;
        }
        _callback_response('ok');
    } catch (Exception $e) {

    }

}

function _callback_response($data)
{
    echo $data;
    exit();
}