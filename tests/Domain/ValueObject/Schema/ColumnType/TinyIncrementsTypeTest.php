<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\TinyIncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

class TinyIncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new TinyIncrementsType();
        $this->assertSame("->tinyIncrements('test')", $columnType->createMigrationMethod($columnName));
    }
}
