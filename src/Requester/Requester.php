<?php
declare(strict_types=1);

namespace LesAbstractClient\Requester;

use LesAbstractClient\Requester\Response\Response;

interface Requester
{
    public function post(string $path, mixed $data): Response;
}
