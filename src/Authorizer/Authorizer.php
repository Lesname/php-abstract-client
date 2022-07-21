<?php
declare(strict_types=1);

namespace LessAbstractClient\Authorizer;

interface Authorizer
{
    public function getAuthorization(): string;
}
