<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\LongTextType;
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
