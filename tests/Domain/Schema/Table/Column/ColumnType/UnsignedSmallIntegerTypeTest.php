<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\UnsignedSmallIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UnsignedSmallIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('unsignedSmallInteger', (new UnsignedSmallIntegerType())->columnType());
    }
}
