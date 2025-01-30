<?php

namespace Src\Controller;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Src\Controller\Controller;

class IndexController extends Controller
{
    private string $view = "landingPage.html.twig";

    public function index()
    {
        $this->response->setContent($this->render($this->view, $this->getElements()));
        $this->response->send();

        return;
    }
}