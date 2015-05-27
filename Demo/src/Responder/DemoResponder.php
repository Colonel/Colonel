<?php

namespace Demo\src\Responder;

use Demo\Application\AbstractResponder;

class DemoResponder extends AbstractResponder
{
    public function helloUser($name)
    {
        return $this
            ->twig
            ->render(
                '@Welcome/hello.html.twig',
                [
                    'name' => $name
                ]
            );
    }
}