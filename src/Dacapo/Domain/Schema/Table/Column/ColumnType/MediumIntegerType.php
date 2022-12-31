<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType;

final class MediumIntegerType implements ColumnType, BooleanArgsColumnType
{
    public function __construct()
    {
    }

    public function columnType(): string
    {
        return 'mediumInteger';
    }
}
