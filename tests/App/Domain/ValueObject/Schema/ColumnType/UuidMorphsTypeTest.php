<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\UuidMorphsType;
use UcanLab\LaravelDacapo\Test\TestCase;

class UuidMorphsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new UuidMorphsType();
        $this->assertSame("->uuidMorphs('test')", $columnType->createMigrationMethod($columnName));
    }
}
