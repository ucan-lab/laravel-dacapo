<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column;

final class ColumnName
{
    /**
     * ColumnName constructor.
     */
    public function __construct(private ?string $name)
    {
    }

    public function hasName(): bool
    {
        return $this->name !== null;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }
}
