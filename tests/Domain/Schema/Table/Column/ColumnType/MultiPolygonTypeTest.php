<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\MultiPolygonType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MultiPolygonTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('multiPolygon', (new MultiPolygonType())->columnType());
    }
}
