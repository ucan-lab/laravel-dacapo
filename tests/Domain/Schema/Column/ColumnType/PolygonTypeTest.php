<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\PolygonType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class PolygonTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('polygon', (new PolygonType())->columnType());
    }
}
