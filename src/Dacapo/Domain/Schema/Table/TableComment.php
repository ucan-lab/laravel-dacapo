<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

final class TableComment
{
    /**
     * TableComment constructor.
     */
    public function __construct(private ?string $value = null)
    {
    }

    public function get(): string
    {
        return $this->value ?? '';
    }

    public function exists(): bool
    {
        return empty($this->value) === false;
    }
}
