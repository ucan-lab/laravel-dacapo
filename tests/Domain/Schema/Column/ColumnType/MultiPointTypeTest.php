<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MultiPointType;
use UcanLab\LaravelDacapo\Test\TestCase;

class MultiPointTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MultiPointType();
        $this->assertSame("->multiPoint('test')", $columnType->createMigrationMethod($columnName));
    }
}