<?php

namespace action;

abstract class Action
{
    private string $name;

    public function getName() {
        return $this->name;
    }
}