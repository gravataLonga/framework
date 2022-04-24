<?php declare(strict_types=1);

namespace Tests\Unit;

use Gravatalonga\Container\Container;

use Gravatalonga\Framework\App;
use function Gravatalonga\Framework\base_path;
use function Gravatalonga\Framework\config_path;
use function Gravatalonga\Framework\container;
use function Gravatalonga\Framework\domain_path;
use function Gravatalonga\Framework\instance;
use function Gravatalonga\Framework\make;
use function Gravatalonga\Framework\public_path;
use function Gravatalonga\Framework\resource_path;
use function Gravatalonga\Framework\storage_path;
use Gravatalonga\Framework\ValueObject\Path;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Gravatalonga\Framework\container
 * @covers \Gravatalonga\Framework\make
 * @covers \Gravatalonga\Framework\instance
 * @covers \Gravatalonga\Framework\config_path
 * @covers \Gravatalonga\Framework\domain_path
 * @covers \Gravatalonga\Framework\public_path
 * @covers \Gravatalonga\Framework\resource_path
 * @covers \Gravatalonga\Framework\storage_path
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

    /**
     * @test
     */
    public function get_instance()
    {
        $c = new Container(['key' => function () {
            return 1 + 1;
        }]);
        Container::setInstance($c);

        $key = instance('key');

        $this->assertEquals(2, $key);
    }

    /**
     * @test
     */
    public function get_instance_return_null_if_cant_find()
    {
        $c = new Container();
        Container::setInstance($c);

        $key = instance('key');

        $this->assertNull($key);
    }

    /**
     * @test
     */
    public function get_instance_default_value()
    {
        $c = new Container();
        Container::setInstance($c);

        $key = instance('key', 123);

        $this->assertEquals(123, $key);
    }

    /**
     * @test
     */
    public function base_path()
    {
        $c = new Container();
        Container::setInstance($c);
        $c->set('path.base', new Path('./tests/fixture/App/HappyPath'));

        $this->assertInstanceOf(Path::class, base_path());
        $this->assertEquals('./tests/fixture/App/HappyPath', (string)base_path());

        $app = new App();
        $app->boot();

        $this->assertInstanceOf(Path::class, base_path());
        $this->assertEquals('/Users/jonathanfontes/Sites/framework', (string)base_path());
    }

    /**
     * @test
     */
    public function config_path()
    {
        $app = new App(new Path('./tests/fixture/App/HappyPath'));
        $app->boot();

        $this->assertInstanceOf(Path::class, config_path());
        $this->assertEquals('./tests/fixture/App/HappyPath/config', (string)config_path());
    }

    /**
     * @test
     */
    public function domain_path()
    {
        $app = new App(new Path('./tests/fixture/App/HappyPath'));
        $app->boot();

        $this->assertInstanceOf(Path::class, domain_path());
        $this->assertEquals('./tests/fixture/App/HappyPath/domain', (string)domain_path());
    }

    /**
     * @test
     */
    public function public_path()
    {
        $app = new App(new Path('./tests/fixture/App/HappyPath'));
        $app->boot();

        $this->assertInstanceOf(Path::class, public_path());
        $this->assertEquals('./tests/fixture/App/HappyPath/public', (string)public_path());
    }

    /**
     * @test
     */
    public function resource_path()
    {
        $app = new App(new Path('./tests/fixture/App/HappyPath'));
        $app->boot();

        $this->assertInstanceOf(Path::class, resource_path());
        $this->assertEquals('./tests/fixture/App/HappyPath/resource', (string)resource_path());
    }

    /**
     * @test
     */
    public function storage_path()
    {
        $app = new App(new Path('./tests/fixture/App/HappyPath'));
        $app->boot();

        $this->assertInstanceOf(Path::class, storage_path());
        $this->assertEquals('./tests/fixture/App/HappyPath/storage', (string)storage_path());
    }
}