<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SmallIncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class SmallIncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new SmallIncrementsType();
        $this->assertSame("->smallIncrements('test')", $columnType->createMigrationMethod($columnName));
    }
}
