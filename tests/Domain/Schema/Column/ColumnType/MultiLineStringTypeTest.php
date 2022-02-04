<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MultiLineStringType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MultiLineStringTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('multiLineString', (new MultiLineStringType())->columnType());
    }
}
