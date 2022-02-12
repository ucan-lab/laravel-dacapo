<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierArgs;

final class IntColumnModifierArgs implements ColumnModifierArgs
{
    /**
     * @param int $value
     */
    public function __construct(private int $value)
    {
    }

    /**
     * @return string
     */
    public function columnModifierArgs(): string
    {
        return (string) $this->value;
    }
}
