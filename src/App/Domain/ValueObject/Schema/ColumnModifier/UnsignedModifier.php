<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnModifier;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnModifier;

class UnsignedModifier implements ColumnModifier
{
    protected bool $value;

    /**
     * CommentModifier constructor.
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function createMigrationMethod(): string
    {
        return '->unsigned()';
    }
}
