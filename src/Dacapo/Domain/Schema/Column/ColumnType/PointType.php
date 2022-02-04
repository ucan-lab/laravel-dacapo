<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

final class PointType implements ColumnType
{
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function columnType(): string
    {
        return 'point';
    }
}
