<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\NullableUuidMorphsType;
use UcanLab\LaravelDacapo\Test\TestCase;

class NullableUuidMorphsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new NullableUuidMorphsType();
        $this->assertSame("->nullableUuidMorphs('test')", $columnType->createMigrationMethod($columnName));
    }
}
