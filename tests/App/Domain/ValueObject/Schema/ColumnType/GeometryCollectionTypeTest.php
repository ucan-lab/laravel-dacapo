<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\GeometryCollectionType;
use UcanLab\LaravelDacapo\Test\TestCase;

class GeometryCollectionTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new GeometryCollectionType();
        $this->assertSame("->geometryCollection('test')", $columnType->createMigrationMethod($columnName));
    }
}

