<?php
declare(strict_types=1);

namespace LessAbstractClient\Requester;

use LessAbstractClient\Requester\Response\Response;

interface Requester
{
    public function post(string $path, mixed $data): Response;
}
