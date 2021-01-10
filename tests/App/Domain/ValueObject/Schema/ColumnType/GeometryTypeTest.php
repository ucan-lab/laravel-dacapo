<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\GeometryType;
use UcanLab\LaravelDacapo\Test\TestCase;

class GeometryTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new GeometryType();
        $this->assertSame("->geometry('test')", $columnType->createMigrationMethod($columnName));
    }
}
