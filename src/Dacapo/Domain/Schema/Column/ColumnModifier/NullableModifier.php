<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

final class NullableModifier implements ColumnModifier
{
    protected bool $value;

    /**
     * NullableModifier constructor.
     * @param bool|null $value
     */
    public function __construct(?bool $value)
    {
        $this->value = $value ?? true;
    }

    /**
     * @return string
     */
    public function createMigrationMethod(): string
    {
        if ($this->value) {
            return '->nullable()';
        }

        return '->nullable(false)';
    }
}
