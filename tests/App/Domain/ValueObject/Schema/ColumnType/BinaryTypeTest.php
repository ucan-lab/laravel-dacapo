<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\BinaryType;
use UcanLab\LaravelDacapo\Test\TestCase;

class BinaryTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new BinaryType();
        $this->assertSame("->binary('test')", $columnType->createMigrationMethod($columnName));
    }
}
