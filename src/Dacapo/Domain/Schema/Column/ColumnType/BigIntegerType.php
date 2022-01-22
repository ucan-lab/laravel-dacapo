<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

final class BigIntegerType extends BaseIntegerType
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'bigInteger';
    }
}
