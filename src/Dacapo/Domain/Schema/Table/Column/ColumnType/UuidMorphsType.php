<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnType;

final class UuidMorphsType implements ColumnType, StringArgsColumnType
{
    public function __construct()
    {
    }

    public function columnType(): string
    {
        return 'uuidMorphs';
    }
}
