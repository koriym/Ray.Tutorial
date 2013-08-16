<?php

namespace Todo10\Inject;

use Ray\Aop\Weave;

trait TodoInjectTrait
{
    private $todo;

    /**
     * @param Weave $todo
     *
     * @Ray\Di\Di\Inject
     * @Ray\Di\Di\Named("todo")
     */
    public function __construct(Weave $todo)
    {
        $this->todo = $todo;
    }
}