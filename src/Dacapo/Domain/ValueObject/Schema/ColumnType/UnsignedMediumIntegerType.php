<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class UnsignedMediumIntegerType extends BaseUnsignedIntegerType
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'unsignedMediumInteger';
    }
}
