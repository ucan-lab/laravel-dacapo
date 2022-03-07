<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\TextType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class TextTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('text', (new TextType())->columnType());
    }
}
