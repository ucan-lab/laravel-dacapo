<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\GeometryType;
use UcanLab\LaravelDacapo\Test\TestCase;

class GeometryTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new GeometryType();
        $this->assertSame("->geometry('test')", $columnType->createMigrationMethod($columnName));
    }
}