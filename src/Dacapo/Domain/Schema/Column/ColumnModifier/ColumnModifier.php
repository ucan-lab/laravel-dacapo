<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierArgs\ColumnModifierArgs;

abstract class ColumnModifier
{
    private ?ColumnModifierArgs $columnModifierArgs;

    /**
     * @param ?ColumnModifierArgs $columnModifierArgs
     */
    public function __construct(?ColumnModifierArgs $columnModifierArgs)
    {
        $this->columnModifierArgs = $columnModifierArgs;
    }

    abstract public function getName(): string;

    /**
     * @return bool
     */
    public function hasColumnModifierArgs(): bool
    {
        return $this->columnModifierArgs !== null;
    }

    /**
     * @return string
     */
    public function columnModifierArgs(): string
    {
        return $this->columnModifierArgs ? $this->columnModifierArgs->columnModifierArgs() : '';
    }
}
