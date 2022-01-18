<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\NullableMorphsType;
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
