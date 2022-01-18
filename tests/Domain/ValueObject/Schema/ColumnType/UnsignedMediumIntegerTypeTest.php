<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\UnsignedMediumIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class UnsignedMediumIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UnsignedMediumIntegerType();
        $this->assertSame("->unsignedMediumInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
