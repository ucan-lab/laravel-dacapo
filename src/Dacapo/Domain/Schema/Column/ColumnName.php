<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column;

final class ColumnName
{
    private ?string $name;

    /**
     * ColumnName constructor.
     * @param string|null $name
     */
    public function __construct(?string $name)
    {
        $this->name = $name;
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
