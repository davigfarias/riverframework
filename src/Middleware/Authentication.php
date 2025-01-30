<?php

namespace Middleware;

use Src\Sessions;
use Config\FrameworkEnvironment;

/**
 * @author Dave Farias (davegfarias@gmail.com)
 * @package Middleware;
 */
class Authentication
{
    public function __construct()
    {
        FrameworkEnvironment::initialize();
    }

    public static function handle(): void
    {
        $session = new Sessions();

        if($session->id_user_on_line === null)
        {
            if(FrameworkEnvironment::getEnv('MODE') == 0) //Development mode
            {
                $return = $_ENV['DEVPATH']. '/public/index.php';
            }

            if($FrameworkEnvironment::getEnv('MODE') == 1) //Production mode
            {
                $return = $_ENV['PRODPATH']. '/public/index.php';
            }

            header("Location: $return");
            exit();
        }
    }
}
