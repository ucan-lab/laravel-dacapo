<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\SmallIncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

class SmallIncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new SmallIncrementsType();
        $this->assertSame("->smallIncrements('test')", $columnType->createMigrationMethod($columnName));
    }
}
