<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MediumIntegerType;
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
