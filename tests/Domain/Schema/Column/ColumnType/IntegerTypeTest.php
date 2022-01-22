<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\IntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class IntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new IntegerType();
        $this->assertSame("->integer('test')", $columnType->createMigrationMethod($columnName));
    }
}
