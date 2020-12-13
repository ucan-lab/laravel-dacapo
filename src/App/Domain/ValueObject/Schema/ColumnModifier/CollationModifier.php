<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnModifier;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnModifier;

class CollationModifier implements ColumnModifier
{
    protected string $value;

    /**
     * CommentModifier constructor.
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
        return sprintf("->collation('%s')", $this->value);
    }
}
