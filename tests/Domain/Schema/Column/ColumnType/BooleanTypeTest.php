<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BooleanType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class BooleanTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new BooleanType();
        $this->assertSame("->boolean('test')", $columnType->createMigrationMethod($columnName));
    }
}
