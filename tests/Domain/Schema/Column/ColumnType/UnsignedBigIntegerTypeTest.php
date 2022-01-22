<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedBigIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class UnsignedBigIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UnsignedBigIntegerType();
        $this->assertSame("->unsignedBigInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
