<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\JsonbType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class JsonbTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('jsonb', (new JsonbType())->columnType());
    }
}
