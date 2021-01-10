<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

class TableComment
{
    protected ?string $value;

    /**
     * TableComment constructor.
     * @param string|null $value
     */
    public function __construct(?string $value = null)
    {
        $this->value = $value;
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
