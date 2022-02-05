<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedDecimalType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UnsignedDecimalTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('unsignedDecimal', (new UnsignedDecimalType())->columnType());
    }
}
