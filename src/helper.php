<?php declare(strict_types=1);

namespace Gravatalonga\Framework {

    use Gravatalonga\Container\Container;
    use Psr\Container\ContainerInterface;

    if (! function_exists('container')) {
        function container(): ContainerInterface
        {
            return Container::getInstance();
        }
    }

    if (! function_exists('make')) {
        function make(string $key, array $arguments = []): mixed
        {
            $container = container();
            return $container->make($key, $arguments);
        }
    }

    if (! function_exists('instance')) {
        function instance(string $key): mixed
        {
            $container = container();
            return $container->has($key) ? $container->get($key) : null;
        }
    }
}