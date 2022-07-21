<?php
declare(strict_types=1);

namespace LessAbstractClient;

use LessAbstractClient\Response\Response;

interface Requester
{
    public function post(string $path, mixed $data): Response;
}
