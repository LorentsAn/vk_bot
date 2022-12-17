<?php

class ActionModel {
    private array $actions = [];

    public function __construct()
    {
        $this->actions = array(
            //TODO пишем классы действий
        );
    }

    public function getAction(string $name) {
        foreach ($this->actions as $action) {
            if (in_array($name, $this->actions->getName())) {

            }
        }
    }
}