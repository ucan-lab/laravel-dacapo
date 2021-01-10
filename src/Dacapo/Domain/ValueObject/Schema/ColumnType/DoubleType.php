<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class DoubleType extends BaseFloatType
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'double';
    }
}
