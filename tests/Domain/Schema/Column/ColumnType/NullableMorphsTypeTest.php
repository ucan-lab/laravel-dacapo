<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\NullableMorphsType;
use UcanLab\LaravelDacapo\Test\TestCase;

class NullableMorphsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new NullableMorphsType();
        $this->assertSame("->nullableMorphs('test')", $columnType->createMigrationMethod($columnName));
    }
}
