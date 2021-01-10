<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\SmallIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class SmallIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new SmallIntegerType();
        $this->assertSame("->smallInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
