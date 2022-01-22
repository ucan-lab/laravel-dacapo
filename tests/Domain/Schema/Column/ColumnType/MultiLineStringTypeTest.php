<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MultiLineStringType;
use UcanLab\LaravelDacapo\Test\TestCase;

class MultiLineStringTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MultiLineStringType();
        $this->assertSame("->multiLineString('test')", $columnType->createMigrationMethod($columnName));
    }
}
