<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\PointType;
use UcanLab\LaravelDacapo\Test\TestCase;

class PointTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new PointType();
        $this->assertSame("->point('test')", $columnType->createMigrationMethod($columnName));
    }
}
