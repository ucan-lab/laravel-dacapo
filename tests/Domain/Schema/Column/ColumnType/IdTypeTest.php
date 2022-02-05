<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\IdType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class IdTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('id', (new IdType())->columnType());
    }
}
