<?php declare(strict_types=1);

namespace Tests\Unit;

use Gravatalonga\Container\Container;

use function Gravatalonga\Framework\container;
use function Gravatalonga\Framework\make;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Gravatalonga\Framework\container
 * @covers \Gravatalonga\Framework\make
 */
class HelperTest extends TestCase
{
    /**
     * @test
     */
    public function container_function_exists()
    {
        $c = new Container(['key' => 123]);
        Container::setInstance($c);

        $this->assertTrue(container()->has('key'));
        $this->assertEquals(123, container()->get('key'));
    }

    /**
     * @test
     */
    public function make_instance()
    {
        $c = new Container(['key' => 123]);
        Container::setInstance($c);

        $key = make('key');

        $this->assertEquals(123, $key);
    }

    /**
     * @test
     */
    public function can_make_instance_with_arguments()
    {
        $c = new Container(['key' => function (int $plus) {
            return 1 + $plus;
        }]);
        Container::setInstance($c);

        $key = make('key', ['plus' => 2]);

        $this->assertEquals(3, $key);
    }
}
