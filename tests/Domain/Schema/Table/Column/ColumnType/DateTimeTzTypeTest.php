<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\DateTimeTzType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DateTimeTzTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('dateTimeTz', (new DateTimeTzType())->columnType());
    }
}
