<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

final class DoubleType extends BaseFloatType
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'double';
    }
}
