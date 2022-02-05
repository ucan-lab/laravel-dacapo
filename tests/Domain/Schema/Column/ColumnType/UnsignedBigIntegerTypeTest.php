<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedBigIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UnsignedBigIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('unsignedBigInteger', (new UnsignedBigIntegerType())->columnType());
    }
}
