<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\UnsignedIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class UnsignedIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UnsignedIntegerType();
        $this->assertSame("->unsignedInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
