<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\UnsignedIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UnsignedIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('unsignedInteger', (new UnsignedIntegerType())->columnType());
    }
}
