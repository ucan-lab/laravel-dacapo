<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\BigIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class BigIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new BigIntegerType();
        $this->assertSame("->bigInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
