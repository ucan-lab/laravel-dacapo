<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BinaryType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class BinaryTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new BinaryType();
        $this->assertSame("->binary('test')", $columnType->createMigrationMethod($columnName));
    }
}
