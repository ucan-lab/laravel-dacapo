<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

class Connection
{
    protected ?string $value;

    /**
     * Connection constructor.
     * @param string|null $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value;
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
        if ($this->hasValue()) {
            return sprintf("connection('%s')->", $this->value);
        }

        return '';
    }
}
