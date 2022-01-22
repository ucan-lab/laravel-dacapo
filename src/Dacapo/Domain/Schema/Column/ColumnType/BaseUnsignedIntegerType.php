<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;
use function is_array;
use function is_bool;
use function is_int;

abstract class BaseUnsignedIntegerType implements ColumnType
{
    protected bool $autoIncrement = false;

    public function __construct($args = null)
    {
        if (is_array($args)) {
            $this->autoIncrement = (bool) $args[0];
        } elseif (is_bool($args)) {
            $this->autoIncrement = $args;
        } elseif (is_int($args)) {
            $this->autoIncrement = (bool) $args;
        }
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if ($this->autoIncrement) {
            return sprintf("->%s('%s', true)", $this->getName(), $columnName->getName());
        }

        return sprintf("->%s('%s')", $this->getName(), $columnName->getName());
    }

    abstract protected function getName(): string;
}
