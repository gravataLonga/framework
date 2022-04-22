<?php declare(strict_types=1);

namespace Tests\Unit;

use Gravatalonga\Container\Container;

use function Gravatalonga\Framework\container;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Gravatalonga\Framework\container
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
}