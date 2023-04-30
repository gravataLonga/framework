<?php

namespace Gravatalonga\Framework;

abstract class Provider implements ServiceProvider
{
    private array $factories = [];

    private array $extensions = [];

    private readonly \ReflectionObject $instance;

    public function __construct()
    {
        $this->instance = new \ReflectionObject($this);
        $this->factories = $this->generateFactories();
    }

    private function generateFactories(): array
    {
        $arr = [];
        foreach ($this->instance->getMethods() as $method) {
            $attributes = $method->getAttributes(Factory::class);
            if (count($attributes) <= 0) {
                continue;
            }

            foreach ($attributes as $attribute) {
                /** @var \Gravatalonga\Framework\Factory $instance */
                $instance = $attribute->newInstance();
                $name = $instance->getName();
                $methodName = $method->getName();
                $arr[$name] = $this->instance->{$methodName}(...);
            }
        }

        return $arr;
    }

    public function factories(): array
    {
        return $this->factories;
    }

    public function extensions(): array
    {
        return $this->extensions;
    }
}