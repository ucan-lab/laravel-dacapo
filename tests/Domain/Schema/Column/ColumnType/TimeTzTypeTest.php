<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimeTzType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class TimeTzTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('timeTz', (new TimeTzType())->columnType());
    }
}
