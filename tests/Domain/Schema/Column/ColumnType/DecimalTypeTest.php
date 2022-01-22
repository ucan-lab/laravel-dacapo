<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DecimalType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DecimalTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|array|string|null $args
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, $args): void
    {
        $columnName = new ColumnName('test');
        $columnType = new DecimalType($args);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'args:null' => [
                'expected' => "->decimal('test')",
                'args' => null,
            ],
            'args:total:int:8' => [
                'expected' => "->decimal('test', 8)",
                'args' => 8,
            ],
            'args:total:string:8' => [
                'expected' => "->decimal('test', 8)",
                'args' => '8',
            ],
            'args:total:string:8,2' => [
                'expected' => "->decimal('test', 8, 2)",
                'args' => '8, 2',
            ],
            'args:total:string:8,2,true' => [
                'expected' => "->decimal('test', 8, 2, true)",
                'args' => '8, 2, true',
            ],
            'args:total:string:8,2,false' => [
                'expected' => "->decimal('test', 8, 2, false)",
                'args' => '8, 2, false',
            ],
            'args:total:string:empty' => [
                'expected' => "->decimal('test')",
                'args' => '',
            ],
            'args:total:array:8' => [
                'expected' => "->decimal('test', 8)",
                'args' => [8],
            ],
            'args:total:array:8,2' => [
                'expected' => "->decimal('test', 8, 2)",
                'args' => [8, 2],
            ],
            'args:total:array:8,2,true' => [
                'expected' => "->decimal('test', 8, 2, true)",
                'args' => [8, 2, true],
            ],
            'args:total:array:8,2,false' => [
                'expected' => "->decimal('test', 8, 2, false)",
                'args' => [8, 2, false],
            ],
            'args:total:array:empty' => [
                'expected' => "->decimal('test')",
                'args' => [],
            ],
        ];
    }
}
