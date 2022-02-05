<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MacAddressType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MacAddressTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('macAddress', (new MacAddressType())->columnType());
    }
}
