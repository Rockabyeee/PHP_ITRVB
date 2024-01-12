<?php

namespace my\Http;

use my\Http\Response;

class SuccessResponse extends Response
{
    protected const SUCCESS = true;

    public function __construct(
        private array $data = []
    ) {}

    protected function payload(): array
    {
        return ['data' => $this->data];
    }

    public function getBody(): string
    {
        return json_encode($this->data);
    }
}