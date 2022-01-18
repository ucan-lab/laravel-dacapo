<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\TinyIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class TinyIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new TinyIntegerType();
        $this->assertSame("->tinyInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
