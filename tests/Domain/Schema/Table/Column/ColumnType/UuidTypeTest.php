<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\UuidType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UuidTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('uuid', (new UuidType())->columnType());
    }
}
