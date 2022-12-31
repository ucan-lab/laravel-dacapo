<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier\ColumnModifierArgs;

use function is_bool;
use function is_int;

final class MixedColumnModifierArgs implements ColumnModifierArgs
{
    public function __construct(private mixed $value)
    {
    }

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
