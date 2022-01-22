<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SoftDeletesTzType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class SoftDeletesTzTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param string $columnName
     * @param int|null $precision
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, string $columnName, ?int $precision): void
    {
        $columnName = new ColumnName($columnName);
        $columnType = new SoftDeletesTzType($precision);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'columnName:empty' => [
                'expected' => '->softDeletesTz()',
                'columnName' => '',
                'precision' => null,
            ],
            'precision:null' => [
                'expected' => "->softDeletesTz('test')",
                'columnName' => 'test',
                'precision' => null,
            ],
            'precision:0' => [
                'expected' => "->softDeletesTz('test', 0)",
                'columnName' => 'test',
                'precision' => 0,
            ],
        ];
    }
}
