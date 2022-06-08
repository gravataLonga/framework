<?php declare(strict_types=1);

namespace Tests\Unit;

use Gravatalonga\Framework\ValueObject\Path;
use Gravatalonga\Framework\ValueObject\PathNotExists;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Gravatalonga\Framework\ValueObject\Path
 */
class PathTest extends TestCase
{
    /**
     * @test
     */
    public function create_path()
    {
        $path = new Path('./');

        $this->assertInstanceOf(Path::class, $path);
    }

    /**
     * @test
     */
    public function throw_exception_if_path_not_exists()
    {
        $this->expectException(PathNotExists::class);
        $this->expectExceptionMessage('path not exists: ./not-exists');

        new Path('./not-exists');
    }

    /**
     * @test
     */
    public function can_convert_string()
    {
        $path = new Path('./');

        $this->assertNotEmpty((string)$path);
    }

    /**
     * @test
     */
    public function can_add_suffix_path()
    {
        $path = new Path('./tests/fixture/ValueObject');

        $newPath = $path->suffix('config');

        $this->assertStringContainsString('/tests/fixture/ValueObject/config', (string)$newPath);
    }

    /**
     * @test
     */
    public function when_adding_suffix_create_new_object()
    {
        $path = new Path('./tests/fixture/ValueObject');

        $newPath = $path->suffix('config');

        $this->assertNotSame($path, $newPath);
    }

    /**
     * @test
     */
    public function when_adding_suffix_original_path_remain_same()
    {
        $path = new Path('./tests/fixture/ValueObject');

        $path->suffix('config');

        $this->assertStringNotContainsString('config', (string)$path);
    }

    /**
     * @test
     */
    public function suffixing_with_leading_slash()
    {
        $path = new Path('./tests/fixture/ValueObject');

        $newPath = $path->suffix('/config');

        $this->assertStringContainsString('/tests/fixture/ValueObject/config', (string)$newPath);
    }

    /**
     * @test
     */
    public function suffixing_with_trailing_and_leading_slash()
    {
        $path = new Path('./tests/fixture/ValueObject');

        $newPath = $path->suffix('/config/');

        $this->assertStringContainsString('/tests/fixture/ValueObject/config', (string)$newPath);
        $this->assertStringNotContainsString('config/', (string)$newPath);
    }
}
