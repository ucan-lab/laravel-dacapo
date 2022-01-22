<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedMediumIntegerType;
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
