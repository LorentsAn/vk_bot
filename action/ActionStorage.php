<?php

//namespace action;

class ActionStorage {
    private array $actions;

    public function __construct()
    {
        $this->actions = array(
            CLOSE_TASK => new CloseTask(),
            GET_SCORE => new GetScore(),
            MAKE_TASK => new MakeTask(),
            GET_ALL_TASK => new GetAllTasks(),
            GET_HELP => new GetHelp(),
            DELETE_TASK => new DeleteTask(),
            //TODO пишем классы действий
        );
    }

    public function getAction(string $name): ?Action  {
        if ($this->actions[$name]) {
                return $this->actions[$name];
        }
        return null;
    }
}