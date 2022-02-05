<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MediumIncrementsType;
use UcanLab\LaravelDacapo\Test\TestCase;

final class MediumIncrementsTypeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->assertSame('mediumIncrements', (new MediumIncrementsType())->columnType());
    }
}
