<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType\SetType;
use UcanLab\LaravelDacapo\Test\TestCase;

class SetTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new SetType(['foo', 'bar']);
        $this->assertSame("->set('test', ['foo', 'bar'])", $columnType->createMigrationMethod($columnName));
    }
}
