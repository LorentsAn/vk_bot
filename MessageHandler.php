<?php

//use action\ActionStorage;

class MessageHandler {
    private ActionStorage $storage;

    public function __construct() {
        $this->storage = new ActionStorage();
    }

    public function process_message($data): string {
        $chat_id = $data->object->peer_id;
        $message = $data->object->text;

        $args = $this->getArgs($message);
        $action = $this->storage->getAction($args[COMMAND]);
        $value = $args[ARGUMENTS];
        $db = new Database();
        $connection = $db->getConnection();

        $user = new User($chat_id, $connection);

        if (!$user->existUser()) {
            $user->createUser();
        }

        if ($action) {
            try {
                $action->execute($user, $value);
                return 'ok';
            } catch (Exception $e) {
                if ($chat_id == ADMIN_ID) {
                    $action->sendMessage($chat_id, $e->getMessage());
                } else {
                    $action->sendMessage($chat_id, ERROR_OCCURRED);
                }
            }
        } else {
            $action = $this->storage->getAction(GET_HELP);
            $action ->execute($user, []);
            return 'ok';
        }
        return "Возникла ошибка";
    }

    private function getArgs(string $text): array
    {
        $command = explode(' ',trim($text))[0];
        $args = [];
        for ($i = 0; $i < 4; $i++) {
            preg_match("/([A-Za-z]*\s*=\s*'*\"*[^'\"\s]*'*\"*)/ui", $text, $arg);
            $text = str_replace($arg[0], '', $text);
            $args[] = $arg[0];
        }
        return [COMMAND => $command, ARGUMENTS => $args];
    }

}
