<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BooleanType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class BooleanTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('boolean', (new BooleanType())->columnType());
    }
}
