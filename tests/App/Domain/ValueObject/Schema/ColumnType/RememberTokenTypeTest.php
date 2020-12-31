<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType\RememberTokenType;
use UcanLab\LaravelDacapo\Test\TestCase;

class RememberTokenTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $columnName = new ColumnName('test');
        $columnType = new RememberTokenType();
        $this->assertSame('->rememberToken()', $columnType->createMigrationMethod($columnName));
    }
}
