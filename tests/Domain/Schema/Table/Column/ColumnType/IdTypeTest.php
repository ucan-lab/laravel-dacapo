<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\IdType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class IdTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('id', (new IdType())->columnType());
    }
}
