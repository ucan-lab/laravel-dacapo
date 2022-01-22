<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SetType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class SetTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new SetType(['foo', 'bar']);
        $this->assertSame("->set('test', ['foo', 'bar'])", $columnType->createMigrationMethod($columnName));
    }
}
