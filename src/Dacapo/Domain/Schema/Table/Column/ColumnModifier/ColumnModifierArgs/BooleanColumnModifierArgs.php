<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier\ColumnModifierArgs;

final class BooleanColumnModifierArgs implements ColumnModifierArgs
{
    /**
     * @param bool $value
     */
    public function __construct(private bool $value)
    {
    }

    /**
     * @return string
     */
    public function columnModifierArgs(): string
    {
        return var_export($this->value, true);
    }
}
