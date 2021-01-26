<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier;

use Exception;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier;

/**
 * DefaultRawModifier class is original ColumnModifier class
 */
class DefaultRawModifier implements ColumnModifier
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
