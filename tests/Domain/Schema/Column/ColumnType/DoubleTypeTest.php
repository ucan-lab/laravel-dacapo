<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DoubleType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DoubleTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('double', (new DoubleType())->columnType());
    }
}
