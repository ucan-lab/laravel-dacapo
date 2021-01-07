<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\MultiPointType;
use UcanLab\LaravelDacapo\Test\TestCase;

class MultiPointTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MultiPointType();
        $this->assertSame("->multiPoint('test')", $columnType->createMigrationMethod($columnName));
    }
}
