<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\DateType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DateTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('date', (new DateType())->columnType());
    }
}
