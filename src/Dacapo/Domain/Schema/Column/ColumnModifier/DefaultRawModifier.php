<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

use Exception;

/**
 * DefaultRawModifier class is original ColumnModifier class
 */
final class DefaultRawModifier implements ColumnModifier
{
    protected string $value;

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
     * @throws Exception
     */
    public function createMigrationMethod(): string
    {
        return sprintf("->default(DB::raw('%s'))", $this->value);
    }
}
