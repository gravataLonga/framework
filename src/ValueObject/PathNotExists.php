<?php declare(strict_types=1);

namespace Gravatalonga\Framework\ValueObject;

use Throwable;

class PathNotExists extends \DomainException
{
    public function __construct(string $path, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('path not exists: %s', $path), $code, $previous);
    }
}
