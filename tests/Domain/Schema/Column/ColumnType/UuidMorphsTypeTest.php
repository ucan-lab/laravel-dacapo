<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UuidMorphsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UuidMorphsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UuidMorphsType();
        $this->assertSame("->uuidMorphs('test')", $columnType->createMigrationMethod($columnName));
    }
}
