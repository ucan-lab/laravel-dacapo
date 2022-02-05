<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\CharType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class CharTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('char', (new CharType())->columnType());
    }
}
