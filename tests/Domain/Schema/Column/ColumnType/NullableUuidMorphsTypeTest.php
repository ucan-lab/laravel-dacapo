<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\NullableUuidMorphsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class NullableUuidMorphsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('nullableUuidMorphs', (new NullableUuidMorphsType())->columnType());
    }
}
