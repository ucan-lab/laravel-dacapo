<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

final class UseCurrentModifier implements ColumnModifier
{
    private bool $value;

    /**
     * UseCurrentModifier constructor.
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
        return '->useCurrent()';
    }
}
