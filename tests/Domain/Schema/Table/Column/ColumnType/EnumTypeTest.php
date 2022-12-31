<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\EnumType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class EnumTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('enum', (new EnumType())->columnType());
    }
}
