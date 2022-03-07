<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\BigIncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class BigIncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('bigIncrements', (new BigIncrementsType())->columnType());
    }
}
