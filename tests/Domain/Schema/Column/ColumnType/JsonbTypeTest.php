<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\JsonbType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class JsonbTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new JsonbType();
        $this->assertSame("->jsonb('test')", $columnType->createMigrationMethod($columnName));
    }
}
