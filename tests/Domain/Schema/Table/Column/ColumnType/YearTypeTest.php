<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\YearType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class YearTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('year', (new YearType())->columnType());
    }
}
