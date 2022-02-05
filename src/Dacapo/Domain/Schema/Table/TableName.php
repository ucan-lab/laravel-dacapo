<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

final class TableName
{
    private string $name;

    /**
     * TableName constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
