<?php
declare(strict_types=1);

namespace LesAbstractClient\Authorizer;

interface Authorizer
{
    public function getAuthorization(): string;
}
