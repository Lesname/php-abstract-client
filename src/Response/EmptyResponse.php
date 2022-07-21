<?php
declare(strict_types=1);

namespace LessAbstractClient\Response;

/**
 * @psalm-immutable
 */
final class EmptyResponse implements Response
{
    public function getCode(): int
    {
        return 204;
    }

    public function getData(): mixed
    {
        return null;
    }
}
