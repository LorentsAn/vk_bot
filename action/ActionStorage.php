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