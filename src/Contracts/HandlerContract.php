<?php

namespace Src\Contract;

use Src\Model\DTO\HandlerResponse; 

interface HandlerContract
{
   public function setSuccessor(HandlerContract $handler): HandlerContract;
   public function handle(mixed $request, ?HandlerResponse $response = null): HandlerResponse; 
}