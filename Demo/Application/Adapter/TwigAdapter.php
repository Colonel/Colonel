<?php

namespace Demo\Application\Adapter;

use Colonel\Configuration;
use Colonel\Debugger;
use Twig_Loader_Filesystem;
use Twig_Environment;


class TwigAdapter
{
    private $twig;
    private $loader;

    public function __construct(
        Configuration $configuration
    ) {
        $this->configuration = $configuration;
        $this->initialise();
    }

    public function initialise()
    {
        $this->loader = new Twig_Loader_Filesystem;

        $this->setPaths(
            $this->configuration['kernel']['root'],
            $this->configuration['twig']['paths']
        );

        $this->twig = new Twig_Environment(
            $this->loader,
            $this->configuration['twig']['options']
        );
    }

    public function render($view, array $parameters = [])
    {
        Debugger::debugStart('twig');
        $view = $this->twig->render($view, $parameters);
        Debugger::debugEnd('twig');
        return $view;
    }

    private function setPaths($projectRoot, array $paths = [])
    {
        foreach ($paths as $namespace => $path) {
            $this->loader->addPath(
                sprintf('%s/%s', $projectRoot, $path),
                $namespace
            );
        }
    }
}