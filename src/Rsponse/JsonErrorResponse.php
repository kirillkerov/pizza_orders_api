<?php

namespace App\Rsponse;

class JsonErrorResponse
{
    private int $code;
    private string $message;

    public function __construct(string $message, int $code = 500)
    {
        $this->message = $message;
        $this->code = $code;
    }

    private function render(): false|string
    {
        http_response_code($this->code);
        return json_encode(['error' => $this->message]);
    }

    public function __toString()
    {
        return $this->render();
    }
}
