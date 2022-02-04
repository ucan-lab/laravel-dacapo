<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DecimalType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DecimalTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('decimal', (new DecimalType())->columnType());
    }
}
