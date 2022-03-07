<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

final class Connection
{
    /**
     * Connection constructor.
     * @param string|null $value
     */
    public function __construct(private ?string $value)
    {
    }

    /**
     * @return string
     */
    public function makeMigration(): string
    {
        if ($this->value !== null) {
            return sprintf("connection('%s')->", $this->value);
        }

        return '';
    }
}
