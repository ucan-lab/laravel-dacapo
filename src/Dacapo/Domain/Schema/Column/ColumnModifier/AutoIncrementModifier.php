<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

final class AutoIncrementModifier implements ColumnModifier
{
    private ?bool $value;

    /**
     * AutoIncrementModifier constructor.
     * @param ?bool $value
     */
    public function __construct(?bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function createMigrationMethod(): string
    {
        return '->autoIncrement()';
    }
}
