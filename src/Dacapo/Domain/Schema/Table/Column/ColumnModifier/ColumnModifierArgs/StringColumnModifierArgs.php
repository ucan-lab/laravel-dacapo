<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier\ColumnModifierArgs;

final class StringColumnModifierArgs implements ColumnModifierArgs
{
    public function __construct(private string $value)
    {
    }

    public function columnModifierArgs(): string
    {
        return sprintf("'%s'", $this->value);
    }
}
