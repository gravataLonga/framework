<?php declare(strict_types=1);

namespace Gravatalonga\Framework {
    use Gravatalonga\Container\Container;
    use Gravatalonga\Framework\ValueObject\Path;
    use Psr\Container\ContainerInterface;

    if (! function_exists('container')) {
        /**
         * @return \Psr\Container\ContainerInterface|Container
         */
        function container(): ContainerInterface
        {
            return Container::getInstance();
        }
    }

    if (! function_exists('make')) {
        /**
         * @param string $key
         * @param array<string, mixed> $arguments
         *
         * @return mixed
         */
        function make(string $key, array $arguments = []): mixed
        {
            /**
             * @var Container
             */
            $container = container();

            return $container->make($key, $arguments);
        }
    }

    if (! function_exists('instance')) {
        function instance(string $key, mixed $value = null): mixed
        {
            $container = container();

            return $container->has($key) ? $container->get($key) : $value;
        }
    }

    if (! function_exists('base_path')) {
        function base_path(): Path
        {
            $cwd = getcwd();

            if ($cwd === false) {
                $cwd = ".";
            }

            $path = new Path($cwd);

            /**
             * @var Path
             */
            return instance('path.base', $path);
        }
    }

    if (! function_exists('config_path')) {
        function config_path(): Path
        {
            $cwd = getcwd();

            if ($cwd === false) {
                $cwd = ".";
            }

            $path = new Path($cwd);

            /**
             * @var Path
             */
            return instance('path.config', $path);
        }
    }

    if (! function_exists('domain_path')) {
        function domain_path(): Path
        {
            $cwd = getcwd();

            if ($cwd === false) {
                $cwd = ".";
            }

            $path = new Path($cwd);

            /**
             * @var Path
             */
            return instance('path.domain', $path);
        }
    }

    if (! function_exists('public_path')) {
        function public_path(): Path
        {
            $cwd = getcwd();

            if ($cwd === false) {
                $cwd = ".";
            }

            $path = new Path($cwd);

            /**
             * @var Path
             */
            return instance('path.public', $path);
        }
    }

    if (! function_exists('resource_path')) {
        function resource_path(): Path
        {
            $cwd = getcwd();

            if ($cwd === false) {
                $cwd = ".";
            }

            $path = new Path($cwd);

            /**
             * @var Path
             */
            return instance('path.resource', $path);
        }
    }

    if (! function_exists('storage_path')) {
        function storage_path(): Path
        {
            $cwd = getcwd();

            if ($cwd === false) {
                $cwd = ".";
            }

            $path = new Path($cwd);

            /**
             * @var Path
             */
            return instance('path.storage', $path);
        }
    }
}
