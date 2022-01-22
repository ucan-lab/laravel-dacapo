<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MacAddressType;
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
