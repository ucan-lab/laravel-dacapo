<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\SoftDeletesTzType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class SoftDeletesTzTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('softDeletesTz', (new SoftDeletesTzType())->columnType());
    }
}
