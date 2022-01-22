<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\EnumType;
use UcanLab\LaravelDacapo\Test\TestCase;

class EnumTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new EnumType(['foo', 'bar']);
        $this->assertSame("->enum('test', ['foo', 'bar'])", $columnType->createMigrationMethod($columnName));
    }
}
