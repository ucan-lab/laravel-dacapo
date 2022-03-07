<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Table\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType\MediumIntegerType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MediumIntegerTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('mediumInteger', (new MediumIntegerType())->columnType());
    }
}
