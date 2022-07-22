<?php
declare(strict_types=1);

namespace LessAbstractClient\Requester\Response;

/**
 * @psalm-immutable
 */
interface Response
{
    public function getCode(): int;

    public function getData(): mixed;
}
