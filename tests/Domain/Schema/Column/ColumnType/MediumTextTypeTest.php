<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MediumTextType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MediumTextTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new MediumTextType();
        $this->assertSame("->mediumText('test')", $columnType->createMigrationMethod($columnName));
    }
}
