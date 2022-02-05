<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\NullableTimestampsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class NullableTimestampsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('nullableTimestamps', (new NullableTimestampsType())->columnType());
    }
}
