<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

final class UnsignedSmallIntegerType extends BaseUnsignedIntegerType
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'unsignedSmallInteger';
    }
}
