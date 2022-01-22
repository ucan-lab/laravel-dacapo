<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

final class CharsetModifier implements ColumnModifier
{
    protected string $value;

    /**
     * CharsetModifier constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function createMigrationMethod(): string
    {
        return sprintf("->charset('%s')", $this->value);
    }
}
