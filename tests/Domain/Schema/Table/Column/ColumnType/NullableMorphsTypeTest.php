<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\NullableMorphsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class NullableMorphsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('nullableMorphs', (new NullableMorphsType())->columnType());
    }
}
