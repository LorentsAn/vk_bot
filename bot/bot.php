<?php


function bot_sendMessage($peer_id, $text, $access_token) {
    $request_params = array(
        'message' => $text,
        'peer_id' => $peer_id,
        'access_token' => $access_token,
        'v' => '5.87'
    );
    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}