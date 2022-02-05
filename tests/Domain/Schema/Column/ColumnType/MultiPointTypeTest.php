<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MultiPointType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MultiPointTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('multiPoint', (new MultiPointType())->columnType());
    }
}
