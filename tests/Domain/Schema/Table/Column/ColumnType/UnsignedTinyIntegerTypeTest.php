<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\UnsignedTinyIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UnsignedTinyIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('unsignedTinyInteger', (new UnsignedTinyIntegerType())->columnType());
    }
}
