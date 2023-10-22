<?php

namespace App\Rsponse;

class JsonResponse
{
    private array $data;
    private int $code;

    public function __construct(array $data, int $code = 200)
    {
        $this->data = $data;
        $this->code = $code;
    }

    private function render(): false|string
    {
        if ($this->code !== 200) {
            http_response_code($this->code);
        }

        return json_encode($this->data);
    }

    public function __toString()
    {
        return $this->render();
    }
}
