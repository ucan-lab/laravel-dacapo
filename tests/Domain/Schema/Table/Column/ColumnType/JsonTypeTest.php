<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\JsonType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class JsonTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('json', (new JsonType())->columnType());
    }
}
