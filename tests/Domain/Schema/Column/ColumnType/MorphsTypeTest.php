<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MorphsType;
use UcanLab\LaravelDacapo\Test\TestCase;

class MorphsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MorphsType();
        $this->assertSame("->morphs('test')", $columnType->createMigrationMethod($columnName));
    }
}
