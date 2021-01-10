<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\ForeignIdType;
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
