<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimestampTzType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class TimestampTzTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('timestampTz', (new TimestampTzType())->columnType());
    }
}
