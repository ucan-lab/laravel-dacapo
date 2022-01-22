<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

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
