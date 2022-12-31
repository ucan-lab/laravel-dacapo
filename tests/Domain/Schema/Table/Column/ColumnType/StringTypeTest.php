<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\StringType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class StringTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('string', (new StringType())->columnType());
    }
}
