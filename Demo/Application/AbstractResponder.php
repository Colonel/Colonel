<?php

namespace Demo\Application;

use Demo\Application\Adapter\TwigAdapter;

abstract class AbstractResponder
{
    public function __construct(
        TwigAdapter $twigAdapter
    ) {
        $this->twig = $twigAdapter;
    }
}