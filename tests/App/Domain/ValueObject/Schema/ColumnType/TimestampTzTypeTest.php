<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\BigIncrementsType;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\TimestampType;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\TimestampTzType;
use UcanLab\LaravelDacapo\Test\TestCase;

class TimestampTzTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|null $precision
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, ?int $precision): void
    {
        $columnName = new ColumnName('test');
        $columnType = new TimestampTzType($precision);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'precision:null' => [
                'expected' => "->timestampTz('test')",
                'precision' => null,
            ],
            'precision:0' => [
                'expected' => "->timestampTz('test', 0)",
                'precision' => 0,
            ],
        ];
    }
}
