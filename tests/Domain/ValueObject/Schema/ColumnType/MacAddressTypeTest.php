<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\MacAddressType;
use UcanLab\LaravelDacapo\Test\TestCase;

class MacAddressTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MacAddressType();
        $this->assertSame("->macAddress('test')", $columnType->createMigrationMethod($columnName));
    }
}
