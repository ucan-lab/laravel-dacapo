<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\StringType;
use UcanLab\LaravelDacapo\Test\TestCase;

class StringTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param int|null $length
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, ?int $length): void
    {
        $columnName = new ColumnName('test');
        $columnType = new StringType($length);
        $this->assertSame($expected, $columnType->createMigrationMethod($columnName));
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'length:null' => [
                'expected' => "->string('test')",
                'length' => null,
            ],
            'length:100' => [
                'expected' => "->string('test', 100)",
                'length' => 100,
            ],
        ];
    }
}
