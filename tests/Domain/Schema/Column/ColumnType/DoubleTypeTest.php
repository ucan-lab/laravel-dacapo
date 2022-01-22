<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DoubleType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DoubleTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|array|string|null $args
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, $args): void
    {
        $columnName = new ColumnName('test');
        $columnType = new DoubleType($args);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'args:null' => [
                'expected' => "->double('test')",
                'args' => null,
            ],
            'args:total:int:8' => [
                'expected' => "->double('test', 8)",
                'args' => 8,
            ],
            'args:total:string:8' => [
                'expected' => "->double('test', 8)",
                'args' => '8',
            ],
            'args:total:string:8,2' => [
                'expected' => "->double('test', 8, 2)",
                'args' => '8, 2',
            ],
            'args:total:string:empty' => [
                'expected' => "->double('test')",
                'args' => '',
            ],
            'args:total:array:8' => [
                'expected' => "->double('test', 8)",
                'args' => [8],
            ],
            'args:total:array:8,2' => [
                'expected' => "->double('test', 8, 2)",
                'args' => [8, 2],
            ],
            'args:total:array:empty' => [
                'expected' => "->double('test')",
                'args' => [],
            ],
        ];
    }
}
