<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierArgs;

final class StringColumnModifierArgs implements ColumnModifierArgs
{
    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
    }

    /**
     * @return string
     */
    public function columnModifierArgs(): string
    {
        return sprintf("'%s'", $this->value);
    }
}
