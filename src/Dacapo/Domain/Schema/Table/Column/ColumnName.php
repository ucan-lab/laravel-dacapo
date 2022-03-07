<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column;

final class ColumnName
{
    /**
     * ColumnName constructor.
     * @param string|null $name
     */
    public function __construct(private ?string $name)
    {
    }

    /**
     * @return bool
     */
    public function hasName(): bool
    {
        return $this->name !== null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string) $this->name;
    }
}
