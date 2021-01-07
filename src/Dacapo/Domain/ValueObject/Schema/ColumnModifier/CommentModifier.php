<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier;

class CommentModifier implements ColumnModifier
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
        return sprintf("->comment('%s')", $this->value);
    }
}
