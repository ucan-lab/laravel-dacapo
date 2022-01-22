<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\NullableTimestampsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class NullableTimestampsTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|null $precision
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, ?int $precision): void
    {
        $columnName = new ColumnName('test');
        $columnType = new NullableTimestampsType($precision);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'precision:null' => [
                'expected' => '->nullableTimestamps()',
                'precision' => null,
            ],
            'precision:0' => [
                'expected' => '->nullableTimestamps(0)',
                'precision' => 0,
            ],
        ];
    }
}
