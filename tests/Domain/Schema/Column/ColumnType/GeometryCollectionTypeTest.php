<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\GeometryCollectionType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class GeometryCollectionTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('geometryCollection', (new GeometryCollectionType())->columnType());
    }
}
