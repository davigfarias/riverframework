<?php

namespace Src\Controller\Template;

use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Src\Sessions;

class Factory
{
    public function __construct(
        private string $path,
        private Sessions $session
    )
    {
    }

    public function create()
    {
        $loader = new FilesystemLoader($this->path);

        $twig = new Environment($loader,[
            'debug' => true, 
            'cache' => false
        ]);

        $twig->addExtension(new DebugExtension());
        $twig->addFunction(new TwigFunction('session', [$this, 'getSession']));

        return $twig;
    }


    public function getSession(): Sessions
    {
        return $this->session = new Sessions();
    }
}