<?php
declare(strict_types=1);

namespace LessAbstractClient\Response;

/**
 * @psalm-immutable
 */
final class DataResponse implements Response
{
    public function __construct(
        private readonly int $code,
        private readonly mixed $data,
    ) {}

    public function getCode(): int
    {
        return $this->code;
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
