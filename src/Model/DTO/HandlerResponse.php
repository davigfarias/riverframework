<?php

namespace Src\Model\DTO;

final class HandlerResponse
{
    private mixed $data;
    private array $errors;

    public function __construct(
        mixed $data = [], 
    array $errors = [])
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function setData(mixed $data): void
    {
        if (is_array($this->data) && is_array($data))
        {
            $this->data = array_merge($this->data, $data);
        } else 
        {
            $this->data = $data;
        }
    }

    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isSuccess(): bool
    {
        return empty($this->errors);
    }
}