<?php
declare(strict_types=1);

namespace LessAbstractClient\Response;

/**
 * @psalm-immutable
 */
interface Response
{
    public function getCode(): int;

    public function getData(): mixed;
}
