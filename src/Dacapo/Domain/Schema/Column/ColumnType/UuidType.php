<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

final class UuidType implements ColumnType
{
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function columnType(): string
    {
        return 'uuid';
    }
}
