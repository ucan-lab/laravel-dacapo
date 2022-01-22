<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BigIncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class BigIncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new BigIncrementsType();
        $this->assertSame("->bigIncrements('test')", $columnType->createMigrationMethod($columnName));
    }
}
