<?php declare(strict_types=1);

namespace Gravatalonga\Framework;

use Throwable;

class BootableTwice extends \LogicException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("can't boot twice", $code, $previous);
    }
}
