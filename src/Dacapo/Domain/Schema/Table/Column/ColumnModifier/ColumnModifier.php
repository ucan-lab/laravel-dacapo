<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier\ColumnModifierArgs\ColumnModifierArgs;

abstract class ColumnModifier
{
    /**
     * @param ?ColumnModifierArgs $columnModifierArgs
     */
    public function __construct(private ?ColumnModifierArgs $columnModifierArgs)
    {
    }

    abstract public function getName(): string;

    final public function hasColumnModifierArgs(): bool
    {
        return $this->columnModifierArgs !== null;
    }

    final public function columnModifierArgs(): string
    {
        return $this->columnModifierArgs ? $this->columnModifierArgs->columnModifierArgs() : '';
    }
}
