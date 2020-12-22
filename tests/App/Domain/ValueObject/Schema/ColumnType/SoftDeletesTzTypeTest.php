<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\SoftDeletesTzType;
use UcanLab\LaravelDacapo\Test\TestCase;

class SoftDeletesTzTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|null $precision
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, ?int $precision): void
    {
        $columnName = new ColumnName('test');
        $columnType = new SoftDeletesTzType($precision);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'precision:null' => [
                'expected' => "->softDeletesTz('test')",
                'precision' => null,
            ],
            'precision:0' => [
                'expected' => "->softDeletesTz('test', 0)",
                'precision' => 0,
            ],
        ];
    }

}
