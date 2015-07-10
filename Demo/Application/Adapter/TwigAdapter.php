<?php

namespace Demo\Application\Adapter;

use Colonel\Configuration;
use Colonel\Profiler;
use Twig_Loader_Filesystem;
use Twig_Environment;


class TwigAdapter
{
    private $twig;
    private $loader;

    public function __construct(
        Configuration $configuration
    ) {
        Profiler::start('templating');
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

        $this->twig->addFunction(new \Twig_SimpleFunction('dump', function() {
            echo '<pre>';
            var_dump(func_get_args());
            echo '</pre>';
        }));

        $this->twig->addGlobal('profile', Profiler::getRuntime());
    }

    public function render($view, array $parameters = [])
    {
        $view = $this->twig->render($view, $parameters);
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