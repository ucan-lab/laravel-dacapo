<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\TinyIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class TinyIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('tinyInteger', (new TinyIntegerType())->columnType());
    }
}
