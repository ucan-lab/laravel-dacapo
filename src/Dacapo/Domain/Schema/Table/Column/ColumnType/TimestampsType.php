<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType;

final class TimestampsType implements ColumnType, AliasColumnType
{
    public function __construct()
    {
    }

    public function columnType(): string
    {
        return 'timestamps';
    }
}
