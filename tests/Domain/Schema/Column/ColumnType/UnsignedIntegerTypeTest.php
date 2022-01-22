<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UnsignedIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UnsignedIntegerType();
        $this->assertSame("->unsignedInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
