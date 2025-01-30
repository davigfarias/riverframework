<?php

namespace Config\Router;

use CoffeeCode\Router\Router;

class RouterAutoload extends Router 
{
    public function __construct(string $baseUrl)
    {
        parent::__construct($baseUrl);
    }

    public function __destruct()
    {
        $this->dispatch();

        if ($this->error()) {
            $this->redirect("/error/{$this->error()}");
        }
    }
}