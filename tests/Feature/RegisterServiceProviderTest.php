<?php

namespace Tests\Feature;

use Gravatalonga\Framework\App;
use Gravatalonga\Framework\ServiceProvider;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Gravatalonga\Framework\App::register
 */
class RegisterServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function can_register_service_provider()
    {
        $class = new class() implements ServiceProvider {
            public function factories(): array
            {
                return ['key' => 123];
            }

            public function extensions(): array
            {
                return [];
            }
        };

        $app = new App();
        $app->register($class);
        $app->boot();

        $this->assertTrue($app->getContainer()->has('key'));
        $this->assertEquals(123, $app->getContainer()->get('key'));
    }

    /**
     * @test
     */
    public function can_extend_service_provider()
    {
        $class = new class() implements ServiceProvider {
            public function factories(): array
            {
                return ['key' => 123];
            }

            public function extensions(): array
            {
                return ['key' => 456];
            }
        };

        $app = new App();
        $app->register($class);
        $app->boot();

        $this->assertTrue($app->getContainer()->has('key'));
        $this->assertEquals(456, $app->getContainer()->get('key'));
    }

    /**
     * @test
     */
    public function extend_is_called_after_factories()
    {
        $classA = new class() implements ServiceProvider {
            public function factories(): array
            {
                return [];
            }

            public function extensions(): array
            {
                return ['key' => 456];
            }
        };

        $classB = new class() implements ServiceProvider {
            public function factories(): array
            {
                return ['key' => 123];
            }

            public function extensions(): array
            {
                return [];
            }
        };

        $app = new App();
        $app->register($classA);
        $app->register($classB);
        $app->boot();

        $this->assertTrue($app->getContainer()->has('key'));
        $this->assertEquals(456, $app->getContainer()->get('key'));
    }

    /**
     * @test
     */
    public function entries_must_be_cached_by_container()
    {
        $classA = new class() implements ServiceProvider {
            public function factories(): array
            {
                return [
                    'key' => function (ContainerInterface $container) {
                        return rand(0, 1000000);
                    },
                ];
            }

            public function extensions(): array
            {
                return [];
            }
        };

        $app = new App();
        $app->register($classA);
        $app->boot();

        $key1 = $app->getContainer()->get('key');
        $key2 = $app->getContainer()->get('key');

        $this->assertEquals($key1, $key2);
    }

    /**
     * @test
     */
    public function can_return_null_from_service_provider()
    {
        $classA = new class() implements ServiceProvider {
            public function factories(): array
            {
                return [
                    'key' => function () {
                        return null;
                    },
                ];
            }

            public function extensions(): array
            {
                return [];
            }
        };

        $app = new App();
        $app->register($classA);
        $app->boot();


        $this->assertTrue($app->getContainer()->has('key'));
        $this->assertNull($app->getContainer()->get('key'));
    }

    /**
     * @test
     */
    public function can_create_alias()
    {
        $classA = new class() implements ServiceProvider {
            public function factories(): array
            {
                return [
                    'key' => function () {
                        return rand(0, 10000);
                    },
                    'alias' => function (ContainerInterface $c) {
                        return $c->get('key');
                    },
                ];
            }

            public function extensions(): array
            {
                return [];
            }
        };

        $app = new App();
        $app->register($classA);
        $app->boot();

        $key1 = $app->getContainer()->get('key');
        $key2 = $app->getContainer()->get('alias');

        $this->assertEquals($key1, $key2);
    }
    
    /**
     * @test
     */
    public function can_overriding_same_entry()
    {
        $classA = new class() implements ServiceProvider {
            public function factories(): array
            {
                return [
                    'key' => function () {
                        return rand(0, 10000);
                    },
                    'alias' => function (ContainerInterface $c) {
                        return $c->get('key');
                    },
                ];
            }

            public function extensions(): array
            {
                return [];
            }
        };

        $classB = new class() implements ServiceProvider {
            public function factories(): array
            {
                return [
                    'key' => 'abc',
                ];
            }

            public function extensions(): array
            {
                return [];
            }
        };

        $app = new App();
        $app->register($classA);
        $app->register($classB);
        $app->boot();

        $this->assertEquals('abc', $app->getContainer()->get('key'));
    }
}