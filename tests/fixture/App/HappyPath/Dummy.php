<?php

namespace Tests\fixture\App\HappyPath;

class Dummy
{
    private string $scope;

    public function __construct(string $scope)
    {
        $this->scope = $scope;
    }

    public function getScope(): string
    {
        return $this->scope;
    }
}