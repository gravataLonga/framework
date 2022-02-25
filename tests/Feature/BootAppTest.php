<?php

namespace Tests\Feature;

use Gravatalonga\Framework\App;
use Gravatalonga\Framework\BootableTwice;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Gravatalonga\Framework\App::boot
 * @covers \Gravatalonga\Framework\App::wasBoot
 */
class BootAppTest extends TestCase
{
    /**
     * @test
     */
    public function can_boot()
    {
        $app = new App();

        $app->boot();

        $this->assertTrue($app->wasBoot());
    }

    /**
     * @test
     */
    public function unable_boot_twice()
    {
        $this->expectException(BootableTwice::class);
        $this->expectExceptionMessage('can\'t boot twice');

        $app = new App();

        $app->boot();
        $app->boot();
    }

    /**
     * @test
     */
    public function create_container()
    {
        $app = new App();
        $app->boot();

        $this->assertInstanceOf(ContainerInterface::class, $app->getContainer());
    }
}
