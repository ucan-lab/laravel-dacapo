<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SoftDeletesType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class SoftDeletesTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('softDeletes', (new SoftDeletesType())->columnType());
    }
}
