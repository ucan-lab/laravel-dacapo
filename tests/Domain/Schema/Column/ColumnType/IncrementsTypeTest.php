<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\IncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class IncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new IncrementsType();
        $this->assertSame("->increments('test')", $columnType->createMigrationMethod($columnName));
    }
}
