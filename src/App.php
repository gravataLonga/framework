<?php declare(strict_types=1);

namespace Gravatalonga\Framework;

use Gravatalonga\Container\Container;
use Gravatalonga\Framework\ValueObject\Path;
use Gravatalonga\Framework\ValueObject\PathNotExists;

final class App
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
        $this->createContainer();
        $this->bindingPath();
        $this->loadConfiguration();
        $this->bindProviderFromConfiguration();
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

    private function bindingPath(): void
    {
        if (is_null($this->basePath)) {
            $this->basePath = new Path(getcwd());
        }

        $this->container->share('path.base', $this->basePath);

        try {
            $this->container->share('path.config', $this->basePath->suffix('config'));
        } catch (PathNotExists $e) {
        }

        try {
            $this->container->share('path.domain', $this->basePath->suffix('domain'));
        } catch (PathNotExists $e) {
        }

        try {
            $this->container->share('path.resource', $this->basePath->suffix('resource'));
        } catch (PathNotExists $e) {
        }

        try {
            $this->container->share('path.storage', $this->basePath->suffix('storage'));
        } catch (PathNotExists $e) {
        }

        try {
            $this->container->share('path.public', $this->basePath->suffix('public'));
        } catch (PathNotExists $e) {
        }
    }

    private function loadConfiguration(): void
    {
        if (! $this->container->has('path.config')) {
            return;
        }

        $config = $this->container->get('path.config');
        foreach (glob($config . '/*.php') as $file) {
            $key = basename($file, '.php');
            $content = require $file;
            $this->container->share('config.' . $key, $content);
        }
    }

    private function bindProviderFromConfiguration(): void
    {
        if (! $this->container->has('config.providers')) {
            return;
        }

        $providers = $this->container->get('config.providers');

        if (! is_array($providers)) {
            return;
        }

        foreach ($providers as $provider) {
            $this->register($provider);
        }
    }

    private function createContainer(): void
    {
        $this->container = new Container();
        Container::setInstance($this->container);
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
