<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

final class Collation
{
    /**
     * Charset constructor.
     * @param string|null $value
     */
    public function __construct(private ?string $value)
    {
    }

    /**
     * @return bool
     */
    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return (string) $this->value;
    }

    /**
     * @return string
     */
    public function makeMigration(): string
    {
        return sprintf("\$table->collation = '%s';", $this->getValue());
    }
}
