<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\JsonType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class JsonTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new JsonType();
        $this->assertSame("->json('test')", $columnType->createMigrationMethod($columnName));
    }
}
