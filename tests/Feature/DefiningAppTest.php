<?php

namespace Tests\Feature;

use Gravatalonga\Framework\App;
use Gravatalonga\Framework\ValueObject\Path;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Gravatalonga\Framework\App::__construct
 * @covers \Gravatalonga\Framework\App::bindPath
 */
class DefiningAppTest extends TestCase
{
    /**
     * @test
     */
    public function when_creating_app_we_can_use_base_path()
    {
        $app = new App(new Path('./tests/fixture/App/HappyPath'));
        $app->boot();

        $this->assertTrue($app->getContainer()->has('path.base'), 'base path not exists');
        $this->assertTrue($app->getContainer()->has('path.config'), 'config path not exists');
        $this->assertTrue($app->getContainer()->has('path.domain'), 'domain path not exists');
        $this->assertTrue($app->getContainer()->has('path.resource'), 'resource path not exists');
        $this->assertTrue($app->getContainer()->has('path.storage'), 'storage path not exists');
        $this->assertTrue($app->getContainer()->has('path.public'), 'public path not exists');

        $this->assertInstanceOf(Path::class, $app->getContainer()->get('path.base'));
        $this->assertInstanceOf(Path::class, $app->getContainer()->get('path.config'));
        $this->assertInstanceOf(Path::class, $app->getContainer()->get('path.domain'));
        $this->assertInstanceOf(Path::class, $app->getContainer()->get('path.resource'));
        $this->assertInstanceOf(Path::class, $app->getContainer()->get('path.storage'));
        $this->assertInstanceOf(Path::class, $app->getContainer()->get('path.public'));
    }

    /**
     * @test
     */
    public function still_im_able_to_create_app_without_path()
    {
        $app = new App();
        $app->boot();

        $this->assertTrue($app->getContainer()->has('path.base'), 'base path not exists');
        $this->assertFalse($app->getContainer()->has('path.config'), 'config path exists');
        $this->assertFalse($app->getContainer()->has('path.domain'), 'domain path exists');
        $this->assertFalse($app->getContainer()->has('path.resource'), 'resource path exists');
        $this->assertFalse($app->getContainer()->has('path.storage'), 'storage path exists');
        $this->assertFalse($app->getContainer()->has('path.public'), 'public path exists');
    }

    /**
     * @test
     */
    public function if_some_folder_are_created_then_binded_them()
    {
        $app = new App(new Path('./tests/fixture/App/SemiPath'));
        $app->boot();

        $this->assertTrue($app->getContainer()->has('path.base'), 'base path not exists');
        $this->assertTrue($app->getContainer()->has('path.config'), 'config path not exists');
        $this->assertFalse($app->getContainer()->has('path.domain'), 'domain path exists');
        $this->assertFalse($app->getContainer()->has('path.resource'), 'resource path exists');
        $this->assertFalse($app->getContainer()->has('path.storage'), 'storage path exists');
        $this->assertFalse($app->getContainer()->has('path.public'), 'public path exists');
    }

    /**
     * @test
     */
    public function each_configuration_has_correct_bind_into_container()
    {
        $app = new App(new Path('./tests/fixture/App/HappyPath'));
        $app->boot();

        $this->assertTrue($app->getContainer()->has('config.providers'));
        $this->assertTrue($app->getContainer()->has('config.app'));

        $this->assertIsArray($app->getContainer()->get('config.providers'));
        $this->assertIsArray($app->getContainer()->get('config.app'));
    }

    /**
     * @test
     */
    public function load_provider_defined_on_config_providers()
    {
        $app = new App(new Path('./tests/fixture/App/HappyPath'));
        $app->boot();

        $key = $app->getContainer()->get('key');

        $this->assertEquals(123, $key);
    }
}