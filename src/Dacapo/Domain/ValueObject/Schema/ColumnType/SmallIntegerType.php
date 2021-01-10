<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class SmallIntegerType extends BaseIntegerType
{
    /**
     * @return string
     */
    protected function getName(): string
    {
        return 'smallInteger';
    }
}
