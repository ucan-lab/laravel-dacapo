<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\UnsignedDecimalType;
use UcanLab\LaravelDacapo\Test\TestCase;

class UnsignedDecimalTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|array|string|null $args
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, $args): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UnsignedDecimalType($args);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'args:null' => [
                'expected' => "->unsignedDecimal('test')",
                'args' => null,
            ],
            'args:total:int:8' => [
                'expected' => "->unsignedDecimal('test', 8)",
                'args' => 8,
            ],
            'args:total:string:8' => [
                'expected' => "->unsignedDecimal('test', 8)",
                'args' => '8',
            ],
            'args:total:string:8,2' => [
                'expected' => "->unsignedDecimal('test', 8, 2)",
                'args' => '8, 2',
            ],
            'args:total:string:empty' => [
                'expected' => "->unsignedDecimal('test')",
                'args' => '',
            ],
            'args:total:array:8' => [
                'expected' => "->unsignedDecimal('test', 8)",
                'args' => [8],
            ],
            'args:total:array:8,2' => [
                'expected' => "->unsignedDecimal('test', 8, 2)",
                'args' => [8, 2],
            ],
            'args:total:array:empty' => [
                'expected' => "->unsignedDecimal('test')",
                'args' => [],
            ],
        ];
    }
}
