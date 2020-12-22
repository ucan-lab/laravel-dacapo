<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\UnsignedSmallIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class UnsignedSmallIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UnsignedSmallIntegerType();
        $this->assertSame("->unsignedSmallInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
