<?php declare(strict_types=1);

namespace Gravatalonga\Framework {
    use Gravatalonga\Container\Container;
    use Gravatalonga\Framework\ValueObject\Path;
    use Psr\Container\ContainerInterface;

    function container(): ContainerInterface
    {
        return Container::getInstance();
    }

    function make(string $key, array $arguments = []): mixed
    {
        $container = container();

        return $container->make($key, $arguments);
    }

    function instance(string $key, mixed $value = null): mixed
    {
        $container = container();

        return $container->has($key) ? $container->get($key) : $value;
    }

    function base_path(): Path
    {
        $cwd = getcwd();

        if ($cwd === false) {
            $cwd = ".";
        }

        $path = new Path($cwd);

        return instance('path.base', $path);
    }

    function config_path(): Path
    {
        $cwd = getcwd();

        if ($cwd === false) {
            $cwd = ".";
        }

        $path = new Path($cwd);

        return instance('path.config', $path);
    }

    function domain_path(): Path
    {
        $cwd = getcwd();

        if ($cwd === false) {
            $cwd = ".";
        }

        $path = new Path($cwd);

        return instance('path.domain', $path);
    }

    function public_path(): Path
    {
        $cwd = getcwd();

        if ($cwd === false) {
            $cwd = ".";
        }

        $path = new Path($cwd);

        return instance('path.public', $path);
    }

    function resource_path(): Path
    {
        $cwd = getcwd();

        if ($cwd === false) {
            $cwd = ".";
        }

        $path = new Path($cwd);

        return instance('path.resource', $path);
    }

    function storage_path(): Path
    {
        $cwd = getcwd();

        if ($cwd === false) {
            $cwd = ".";
        }

        $path = new Path($cwd);

        return instance('path.storage', $path);
    }
}
