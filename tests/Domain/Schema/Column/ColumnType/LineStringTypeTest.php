<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\LineStringType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class LineStringTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('lineString', (new LineStringType())->columnType());
    }
}
