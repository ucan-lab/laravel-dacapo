<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\UuidType;
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
