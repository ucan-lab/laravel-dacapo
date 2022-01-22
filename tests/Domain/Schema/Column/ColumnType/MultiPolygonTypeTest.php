<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MultiPolygonType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MultiPolygonTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MultiPolygonType();
        $this->assertSame("->multiPolygon('test')", $columnType->createMigrationMethod($columnName));
    }
}
