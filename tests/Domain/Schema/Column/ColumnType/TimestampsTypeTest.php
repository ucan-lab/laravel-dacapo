<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimestampsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class TimestampsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('timestamps', (new TimestampsType())->columnType());
    }
}
