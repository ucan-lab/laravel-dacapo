<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\UnsignedTinyIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class UnsignedTinyIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UnsignedTinyIntegerType();
        $this->assertSame("->unsignedTinyInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
