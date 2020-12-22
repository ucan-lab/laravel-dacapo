<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\JsonbType;
use UcanLab\LaravelDacapo\Test\TestCase;

class JsonbTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new JsonbType();
        $this->assertSame("->jsonb('test')", $columnType->createMigrationMethod($columnName));
    }
}
