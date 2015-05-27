<?php

namespace Demo\src\Controller;

use Demo\Application\AbstractController;
use Demo\src\Responder\DemoResponder;

class DemoController
{
    public function __construct(
        DemoResponder $demoResponder
    ) {
        $this->responder = $demoResponder;
    }

    public function index(
        $name
    ) {
        return $this
            ->responder
            ->helloUser($name);
    }
}