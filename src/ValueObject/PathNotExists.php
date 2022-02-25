<?php

namespace Gravatalonga\Framework\ValueObject;

use Throwable;

class PathNotExists extends \DomainException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('path not exists', $code, $previous);
    }
}
