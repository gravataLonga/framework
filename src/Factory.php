<?php

namespace Gravatalonga\Framework;

#[\Attribute(\Attribute::TARGET_METHOD)]
final class Factory
{
    public function __construct(private readonly ?string $name = null)
    {
    }

    public function getName(): string|null
    {
        return $this->name;
    }
}