<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\BigIncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

class BigIncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new BigIncrementsType();
        $this->assertSame("->bigIncrements('test')", $columnType->createMigrationMethod($columnName));
    }
}
