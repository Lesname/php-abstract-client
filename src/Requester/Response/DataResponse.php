<?php
declare(strict_types=1);

namespace LesAbstractClient\Requester\Response;

use Override;

/**
 * @psalm-immutable
 */
final class DataResponse implements Response
{
    public function __construct(
        private readonly int $code,
        private readonly mixed $data,
    ) {}

    #[Override]
    public function getCode(): int
    {
        return $this->code;
    }

    #[Override]
    public function getData(): mixed
    {
        return $this->data;
    }
}
