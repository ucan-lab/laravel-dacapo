<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\DateTimeType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DateTimeTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('dateTime', (new DateTimeType())->columnType());
    }
}
