<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedSmallIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UnsignedSmallIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UnsignedSmallIntegerType();
        $this->assertSame("->unsignedSmallInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
