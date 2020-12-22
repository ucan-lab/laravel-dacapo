<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\UnsignedBigIntegerType;
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
