<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\MediumIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

class MediumIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MediumIntegerType();
        $this->assertSame("->mediumInteger('test')", $columnType->createMigrationMethod($columnName));
    }
}
