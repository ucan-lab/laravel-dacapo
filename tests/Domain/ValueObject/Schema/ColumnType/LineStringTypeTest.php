<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\LineStringType;
use UcanLab\LaravelDacapo\Test\TestCase;

class LineStringTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new LineStringType();
        $this->assertSame("->lineString('test')", $columnType->createMigrationMethod($columnName));
    }
}
