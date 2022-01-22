<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\CharType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class CharTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|null $length
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, ?int $length): void
    {
        $columnName = new ColumnName('test');
        $columnType = new CharType($length);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'length:null' => [
                'expected' => "->char('test')",
                'length' => null,
            ],
            'length:100' => [
                'expected' => "->char('test', 100)",
                'length' => 100,
            ],
        ];
    }
}
