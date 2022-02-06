<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierArgs;

use function is_int;
use function is_bool;

final class MixedColumnModifierArgs implements ColumnModifierArgs
{
    private mixed $value;

    /**
     * @param mixed $value
     */
    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function columnModifierArgs(): string
    {
        if (is_int($this->value)) {
            return (string) $this->value;
        } elseif (is_bool($this->value)) {
            return var_export($this->value, true);
        }

        return sprintf("'%s'", $this->value);
    }
}
