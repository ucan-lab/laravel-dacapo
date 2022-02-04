<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\GeometryType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class GeometryTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('geometry', (new GeometryType())->columnType());
    }
}
