<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\CharType;
use UcanLab\LaravelDacapo\Test\TestCase;

class CharTypeTest extends TestCase
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
