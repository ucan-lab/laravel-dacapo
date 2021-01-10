<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\EnumType;
use UcanLab\LaravelDacapo\Test\TestCase;

class EnumTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new EnumType(['foo', 'bar']);
        $this->assertSame("->enum('test', ['foo', 'bar'])", $columnType->createMigrationMethod($columnName));
    }
}
