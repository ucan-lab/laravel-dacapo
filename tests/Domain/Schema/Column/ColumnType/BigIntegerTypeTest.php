<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BigIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class BigIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new BigIntegerType();
        $this->assertSame("->bigInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
