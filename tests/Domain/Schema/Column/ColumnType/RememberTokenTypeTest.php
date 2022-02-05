<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\RememberTokenType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class RememberTokenTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('rememberToken', (new RememberTokenType())->columnType());
    }
}
