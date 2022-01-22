<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

/**
 * DefaultRawModifier class is original ColumnModifier class
 */
final class DefaultRawModifier implements ColumnModifier
{
    private string $value;

    /**
     * DefaultRawModifier constructor.
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
        return sprintf("->default(DB::raw('%s'))", $this->value);
    }
}
