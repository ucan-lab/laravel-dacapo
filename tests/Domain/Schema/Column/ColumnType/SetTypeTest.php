<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SetType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class SetTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('set', (new SetType())->columnType());
    }
}
