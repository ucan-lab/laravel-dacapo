<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\PolygonType;
use UcanLab\LaravelDacapo\Test\TestCase;

class PolygonTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new PolygonType();
        $this->assertSame("->polygon('test')", $columnType->createMigrationMethod($columnName));
    }
}
