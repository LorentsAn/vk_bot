<?php


class MessageHandler {
    private ActionStorage $storage;

    public function __construct() {
        $this->storage = new ActionStorage();
    }

    public function process_message($data): string {
        $chat_id = $data->object->peer_id;
        $user_id = $data->object->from_id;
        $message = $data->object->text;

        $args = $this->getArgs($message);
        $action = $this->storage->getAction($args[COMMAND]);
        $value = $args[ARGUMENTS];
        $db = new Database();
        $connection = $db->getConnection();

        $user = new User($user_id, $connection);

        if (!$user->existUser()) {
            $user->createUser();
        }

        if ($action) {
            try {
                $action->execute($user, $value, $chat_id);
                return 'ok';
            } catch (Exception $e) {
                if ($chat_id == ADMIN_ID) {
                    $action->sendMessage($chat_id, $e->getMessage());
                } else {
                    $action->sendMessage($chat_id, ERROR_OCCURRED);
                }
            }
        } else {
            if ($args[COMMAND][0] == "\\") {
                bot_sendMessage($user->id, INVALID_COMMAND, VK_API_ACCESS_TOKEN);
            }
            return 'ok';
        }
        return ERROR_OCCURRED;
    }

    public function getArgs(string $text): array
    {
        $command = explode(' ',trim($text))[0];
        $args = [];
        for ($i = 0; $i < 4; $i++) {
            preg_match("/[A-Za-z]*\s*=\s*[^,]*,*/ui", $text, $arg);
            $text = str_replace($arg[0], '', $text);
            $args[] = $arg[0];
        }
        return [COMMAND => $command, ARGUMENTS => $args];
    }

}
