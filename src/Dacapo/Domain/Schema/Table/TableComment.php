<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

final class TableComment
{
    /**
     * TableComment constructor.
     * @param string|null $value
     */
    public function __construct(private ?string $value = null)
    {
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->value ?? '';
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return empty($this->value) === false;
    }
}
