<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UuidType;
use UcanLab\LaravelDacapo\Test\TestCase;

class UuidTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UuidType();
        $this->assertSame("->uuid('test')", $columnType->createMigrationMethod($columnName));
    }
}
