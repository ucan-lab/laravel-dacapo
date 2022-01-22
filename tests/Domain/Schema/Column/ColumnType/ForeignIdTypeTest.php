<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ForeignIdType;
use UcanLab\LaravelDacapo\Test\TestCase;

class ForeignIdTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new ForeignIdType();
        $this->assertSame("->foreignId('test')", $columnType->createMigrationMethod($columnName));
    }
}
