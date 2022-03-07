<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\ForeignIdType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class ForeignIdTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('foreignId', (new ForeignIdType())->columnType());
    }
}
