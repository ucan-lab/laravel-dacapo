<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier;

class AutoIncrementModifier implements ColumnModifier
{
    protected bool $value;

    /**
     * AutoIncrementModifier constructor.
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value ?? true;
    }

    /**
     * @return string
     */
    public function createMigrationMethod(): string
    {
        return '->autoIncrement()';
    }
}
