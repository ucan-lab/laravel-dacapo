<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

class TinyIntegerType implements ColumnType
{
    protected bool $autoIncrement = false;
    protected bool $unsigned = false;

    public function __construct($args = null)
    {
        if (is_array($args) && count($args) === 2) {
            $this->autoIncrement = (bool) $args[0];
            $this->unsigned =(bool) $args[1];
        } elseif (is_array($args) && count($args) === 1) {
            $this->autoIncrement = (bool) $args[0];
            $this->unsigned = false;
        } elseif (is_bool($args)) {
            $this->autoIncrement = $args;
            $this->unsigned = false;
        } elseif (is_int($args)) {
            $this->autoIncrement = (bool) $args;
            $this->unsigned = false;
        }
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if ($this->autoIncrement && $this->unsigned) {
            return sprintf("->tinyInteger('%s', true, true)", $columnName->getName());
        } elseif ($this->autoIncrement && $this->unsigned === false) {
            return sprintf("->tinyInteger('%s', true)", $columnName->getName());
        } elseif ($this->autoIncrement === false && $this->unsigned) {
            return sprintf("->tinyInteger('%s', false, true)", $columnName->getName());
        }

        return sprintf("->tinyInteger('%s')", $columnName->getName());
    }
}
