<?php

namespace Todo10\Application;

use Todo10\Inject\TodoInjectTrait;

class Board
{
    use TodoInjectTrait;

    public function addTodo($todo)
    {
        $this->todo->add($todo);
    }

    public function addToEat($food)
    {
    }

    public function addToResearch($event)
    {
    }
}
