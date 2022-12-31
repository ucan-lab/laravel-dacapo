<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier\ColumnModifierArgs;

final class IntColumnModifierArgs implements ColumnModifierArgs
{
    public function __construct(private int $value)
    {
    }

    public function columnModifierArgs(): string
    {
        return (string) $this->value;
    }
}
