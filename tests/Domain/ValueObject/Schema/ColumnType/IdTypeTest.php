<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\IdType;
use UcanLab\LaravelDacapo\Test\TestCase;

class IdTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new IdType();
        $this->assertSame('->id()', $columnType->createMigrationMethod($columnName));
    }
}
