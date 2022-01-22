<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

final class IndexModifier implements ColumnModifier
{
    protected bool $value;

    /**
     * IndexModifier constructor.
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
        return '->index()';
    }
}
