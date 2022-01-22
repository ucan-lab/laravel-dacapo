<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TinyIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class TinyIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new TinyIntegerType();
        $this->assertSame("->tinyInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
