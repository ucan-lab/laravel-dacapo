<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MediumTextType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MediumTextTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('mediumText', (new MediumTextType())->columnType());
    }
}
