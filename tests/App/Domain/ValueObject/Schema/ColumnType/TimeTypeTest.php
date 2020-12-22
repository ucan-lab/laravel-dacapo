<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\TimeType;
use UcanLab\LaravelDacapo\Test\TestCase;

class TimeTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|null $precision
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, ?int $precision): void
    {
        $columnName = new ColumnName('test');
        $columnType = new TimeType($precision);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'precision:null' => [
                'expected' => "->time('test')",
                'precision' => null,
            ],
            'precision:0' => [
                'expected' => "->time('test', 0)",
                'precision' => 0,
            ],
        ];
    }
}
