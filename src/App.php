<?php

namespace Gravatalonga\Framework;

use Gravatalonga\Container\Container;
use Gravatalonga\Framework\ValueObject\Path;
use Gravatalonga\Framework\ValueObject\PathNotExists;

class App
{
    private bool $boot = false;

    /**
     * @var ServiceProvider[]
     */
    private array $providers = [];

    /**
     * @var Container
     */
    private Container $container;

    private ?Path $basePath;

    public function __construct(?Path $path = null)
    {
        $this->basePath = $path;
    }

    public function boot(): void
    {
        if ($this->boot) {
            throw new BootableTwice();
        }

        $this->boot = true;
        $this->buildContainer();
        $this->bindPath();
        $this->loadProviders();
    }

    public function register(ServiceProvider $provider): void
    {
        $this->providers[] = $provider;
    }

    public function wasBoot(): bool
    {
        return $this->boot;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    private function bindPath(): void
    {
        if (is_null($this->basePath)) {
            $cwd = getcwd();
            $this->container->set('path.base', new Path(empty($cwd) ? "./" : $cwd));

            return;
        }

        $this->container->set('path.base', $this->basePath);

        try {
            $this->container->set('path.config', $this->basePath->suffix('config'));
        } catch (PathNotExists $e) {
        }

        try {
            $this->container->set('path.domain', $this->basePath->suffix('domain'));
        } catch (PathNotExists $e) {
        }

        try {
            $this->container->set('path.resource', $this->basePath->suffix('resource'));
        } catch (PathNotExists $e) {
        }

        try {
            $this->container->set('path.storage', $this->basePath->suffix('storage'));
        } catch (PathNotExists $e) {
        }

        try {
            $this->container->set('path.public', $this->basePath->suffix('public'));
        } catch (PathNotExists $e) {
        }
    }

    private function buildContainer(): void
    {
        $this->container = new Container();
    }

    private function loadProviders(): void
    {
        foreach ($this->yieldProviders('factories') as $key => $factory) {
            $this->container->share($key, $factory);
        }

        foreach ($this->yieldProviders('extensions') as $key => $extend) {
            $this->container->extend($key, $extend);
        }
    }

    private function yieldProviders(string $type): \Generator
    {
        foreach ($this->providers as $provider) {
            $entries = $provider->{$type}();
            foreach ($entries as $key => $entry) {
                yield $key => $entry;
            }
        }
    }
}
