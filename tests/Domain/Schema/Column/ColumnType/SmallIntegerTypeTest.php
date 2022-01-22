<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SmallIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class SmallIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new SmallIntegerType();
        $this->assertSame("->smallInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
