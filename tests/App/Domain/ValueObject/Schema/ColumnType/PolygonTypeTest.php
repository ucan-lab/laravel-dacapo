<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\PolygonType;
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
