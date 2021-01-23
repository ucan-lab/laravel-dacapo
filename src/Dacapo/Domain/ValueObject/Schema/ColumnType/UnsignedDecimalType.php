<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class UnsignedDecimalType extends BaseFloatType
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'unsignedDecimal';
    }
}
