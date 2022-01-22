<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

final class GeneratedAsModifier implements ColumnModifier
{
    private string $value;

    /**
     * GeneratedAsModifier constructor.
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
        return sprintf("->generatedAs('%s')", $this->value);
    }
}
