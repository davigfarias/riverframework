<?php

namespace Src\Services\Handlers;

use Src\Contracts\HandlerContract;
use Src\Model\DTO\HandlerResponse;

abstract class Handler implements HandlerContract
{
    protected ?HandlerContract $successor = null;

    public function setSucessor(HandlerContract $handler): HandlerContract
    {
        $this->successor = $handler;
        
        return $handler;
    }

    public function handle(mixed $request, ?HandlerResponse $response = null): HandlerResponse
    {
        $response = $this->handleRequest($request, $response);

        if ($response->isSuccess() && $this->successor !== null)
        {
            return $this->successor->handle($request, $response);
        }

        return $response;
    }

    abstract protected function handleRequest(mixed $request, ?HandlerResponse $response): HandlerResponse;

}