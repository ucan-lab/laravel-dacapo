<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\IntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class IntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('integer', (new IntegerType())->columnType());
    }
}
