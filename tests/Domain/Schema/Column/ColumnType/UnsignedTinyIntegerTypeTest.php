<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedTinyIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UnsignedTinyIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('unsignedTinyInteger', (new UnsignedTinyIntegerType())->columnType());
    }
}
