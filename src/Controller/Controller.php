<?php

namespace Src\Controller;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Src\Controller\Template\Factory;
use Src\HTTP\Response;
use Src\HTTP\Request;
use Src\Sessions;
use Twig\Environment;
use Config\FrameworkEnvironment;

abstract class Controller
{
    protected $actualpath;
    protected $path;
    protected $elements = [];
    protected $request;
    protected Sessions $session;
    protected Response $response;
    protected Environment $template;

    public function __construct()
    {
        FrameworkEnvironment::initialize();

        $this->path();
        $this->session = new Sessions();
        $this->response = new Response();
        $this->request = Request::createFromGlobals();
    }

    protected function path(): void
    {
        $mode = FrameworkEnvironment::getEnv('MODE');

        if($mode === 0)
        {
            $this->actualPath = FrameworkEnvironment::getEnv('DEVPATH');
        };

        if($mode === 1)
        {
            $this->actualPath = FrameworkEnvironment::getEnv('PROGPATH');
        };
    }

    protected function redirect(): void
    {
        $redirect = $request->server->PHP_SELF;

        header('Location: '. $redirect);
        exit;
    }

    protected function redirectTo(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function baseElements(): array
    {
        return [
            'title' => FrameworkEnvironment::getEnv('APPLICATION_NAME')
        ];
    }

    protected function addToView(array $elements): void
    {
        if(!is_array($elements))
        {
            throw new \InvalidArtumentException('The parameter $elements should be an array!');
        }

        if(empty($this->elements))
        {
            $this->elements = $this->baseElements();
        }

        $this->elements = array_merge($this->elements, $elements);
    }

    protected function getElements():array
    {
        if(empty($this->elements))
        {
            $this->elements = $this->baseElements();
        }

        return $this->elements;
    }

    protected function render($view, $elements)
    {
        return $this->template()->render($view, $elements);
    }

    private function template()
    {
        $instance = new Factory(path: __DIR__ . FrameworkEnvironment::getEnv('TEMPLATES_PATH'), session: $this->session);
        $this->template = $instance->create();

        return $this->template;
    }

    protected function setError(string $error)
    {
        if(!empty($error))
        {
            $this->session->addError($error);
            $this->redirect();
        }

        return;    
    }
}
