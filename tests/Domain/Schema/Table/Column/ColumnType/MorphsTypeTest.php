<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\MorphsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MorphsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('morphs', (new MorphsType())->columnType());
    }
}
