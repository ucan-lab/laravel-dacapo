<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\MediumIncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

class MediumIncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MediumIncrementsType();
        $this->assertSame("->mediumIncrements('test')", $columnType->createMigrationMethod($columnName));
    }
}
