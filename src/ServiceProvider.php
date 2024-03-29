<?php declare(strict_types=1);

namespace Gravatalonga\Framework;

interface ServiceProvider
{
    /**
     * @return array<string, mixed>
     */
    public function factories(): array;

    /**
     * @return array<string, mixed>
     */
    public function extensions(): array;
}
