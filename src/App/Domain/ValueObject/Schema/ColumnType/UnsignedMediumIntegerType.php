<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

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
