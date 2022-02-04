<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimeType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class TimeTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('time', (new TimeType())->columnType());
    }
}
