<?php declare(strict_types=1);

namespace Tests\fixture\App\HappyPath;

use Gravatalonga\Framework\ServiceProvider;

class Stub implements ServiceProvider
{
    public function factories(): array
    {
        return ['key' => 123];
    }

    public function extensions(): array
    {
        return [];
    }
};
