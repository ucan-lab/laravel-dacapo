<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use function is_int;

final class CharType implements ColumnType
{
    /**
     * @var int|null
     */
    private ?int $args;

    public function __construct(?int $args)
    {
        $this->args = $args;
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if (is_int($this->args)) {
            return sprintf("->char('%s', %d)", $columnName->getName(), $this->args);
        }

        return sprintf("->char('%s')", $columnName->getName());
    }
}
