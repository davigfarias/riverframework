<?php

namespace Config\Container;

use DI\ContainerBuilder;
use DI\Container;
use Src\Contract\ContainerContract;

final class GeneralContainer implements ContainerContract
{
    private Container $container;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        //$containerBuilder->useAutowiring(true);
        $this->configureDefinitions($containerBuilder);
        $this->container = $containerBuilder->build();
    }

    private function configureDefinitions(ContainerBuilder $containerBuilder)
    {
        // $definitions = [
        //     'definition' => \DI\get(CLASS:class)
        // ]

        $containerBuilder->addDefinitions($definitions);
    }

    public function get(string $id)
    {
        return $this->container->get($id);
    }
}