<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\PointType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class PointTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('point', (new PointType())->columnType());
    }
}
