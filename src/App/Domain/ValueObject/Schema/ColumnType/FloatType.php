<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

class FloatType extends BaseFloatType
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'float';
    }
}
