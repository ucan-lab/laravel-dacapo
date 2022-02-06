<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierArgs;

final class StringColumnModifierArgs implements ColumnModifierArgs
{
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function columnModifierArgs(): string
    {
        return sprintf("'%s'", $this->value);
    }
}
