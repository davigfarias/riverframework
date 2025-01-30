<?php

namespace Src\Contracts;

interface ContainerContract
{
    public function get(string $id);
}