<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierArgs;

final class BooleanColumnModifierArgs implements ColumnModifierArgs
{
    private bool $value;

    /**
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function columnModifierArgs(): string
    {
        return var_export($this->value, true);
    }
}
