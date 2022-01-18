<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\MultiPolygonType;
use UcanLab\LaravelDacapo\Test\TestCase;

class MultiPolygonTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MultiPolygonType();
        $this->assertSame("->multiPolygon('test')", $columnType->createMigrationMethod($columnName));
    }
}
