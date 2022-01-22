<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\FloatType;
use UcanLab\LaravelDacapo\Test\TestCase;

class FloatTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|array|string|null $args
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, $args): void
    {
        $columnName = new ColumnName('test');
        $columnType = new FloatType($args);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'args:null' => [
                'expected' => "->float('test')",
                'args' => null,
            ],
            'args:total:int:8' => [
                'expected' => "->float('test', 8)",
                'args' => 8,
            ],
            'args:total:string:8' => [
                'expected' => "->float('test', 8)",
                'args' => '8',
            ],
            'args:total:string:8,2' => [
                'expected' => "->float('test', 8, 2)",
                'args' => '8, 2',
            ],
            'args:total:string:empty' => [
                'expected' => "->float('test')",
                'args' => '',
            ],
            'args:total:array:8' => [
                'expected' => "->float('test', 8)",
                'args' => [8],
            ],
            'args:total:array:8,2' => [
                'expected' => "->float('test', 8, 2)",
                'args' => [8, 2],
            ],
            'args:total:array:empty' => [
                'expected' => "->float('test')",
                'args' => [],
            ],
        ];
    }
}
