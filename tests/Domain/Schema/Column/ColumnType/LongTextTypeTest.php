<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\LongTextType;
use UcanLab\LaravelDacapo\Test\TestCase;

class LongTextTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new LongTextType();
        $this->assertSame("->longText('test')", $columnType->createMigrationMethod($columnName));
    }
}
