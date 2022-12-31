<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier\ColumnModifierArgs;

final class BooleanColumnModifierArgs implements ColumnModifierArgs
{
    public function __construct(private bool $value)
    {
    }

    public function columnModifierArgs(): string
    {
        return var_export($this->value, true);
    }
}
