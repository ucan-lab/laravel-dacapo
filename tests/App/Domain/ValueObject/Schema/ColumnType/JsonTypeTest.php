<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\JsonType;
use UcanLab\LaravelDacapo\Test\TestCase;

class JsonTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new JsonType();
        $this->assertSame("->json('test')", $columnType->createMigrationMethod($columnName));
    }
}
