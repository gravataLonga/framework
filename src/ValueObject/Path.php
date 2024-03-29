<?php declare(strict_types=1);

namespace Gravatalonga\Framework\ValueObject;

class Path implements \Stringable
{
    private readonly string $path;

    public function __construct(string $path)
    {
        if (! file_exists($path)) {
            throw new PathNotExists($path);
        }

        $this->path = $path;
    }

    public function suffix(string $path): self
    {
        $path = $this->path . '/' . trim($path, '/');

        return new self($path);
    }

    public function __toString(): string
    {
        return $this->path;
    }
}
