<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

class FloatType implements ColumnType
{
    /**
     * @var int|array|string
     */
    protected $args;

    public function __construct($args = null)
    {
        $this->args = $args;
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if (is_array($this->args) && count($this->args) === 2) {
            return sprintf("->float('%s', %d, %d)", $columnName->getName(), $this->args[0], $this->args[1]);
        } elseif (is_array($this->args) && count($this->args) === 1) {
            return sprintf("->float('%s', %d)", $columnName->getName(), $this->args[0]);
        } elseif (is_int($this->args)) {
            return sprintf("->float('%s', %s)", $columnName->getName(), $this->args);
        } elseif (is_string($this->args) && $this->args !== '') {
            return sprintf("->float('%s', %s)", $columnName->getName(), $this->args);
        }

        return sprintf("->float('%s')", $columnName->getName());
    }
}
