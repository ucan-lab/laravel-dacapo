<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\FloatType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class FloatTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('float', (new FloatType())->columnType());
    }
}
