<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\BooleanType;
use UcanLab\LaravelDacapo\Test\TestCase;

class BooleanTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new BooleanType();
        $this->assertSame("->boolean('test')", $columnType->createMigrationMethod($columnName));
    }
}
