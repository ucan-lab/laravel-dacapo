<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

abstract class BaseFloatType implements ColumnType
{
    protected ?int $total = null;
    protected ?int $places = null;

    public function __construct($args = null)
    {
        if (is_string($args) && $args !== '') {
            $args = explode(',', $args);
        }

        if (is_array($args)) {
            $this->total = isset($args[0]) ? (int) $args[0] : null;
            $this->places = isset($args[1]) ? (int) $args[1] : null;
        } elseif (is_int($args)) {
            $this->total = $args;
        }
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if (is_int($this->total) && is_int($this->places)) {
            return sprintf("->%s('%s', %d, %d)", $this->getName(), $columnName->getName(), $this->total, $this->places);
        } elseif (is_int($this->total) && is_int($this->places) === false) {
            return sprintf("->%s('%s', %d)", $this->getName(), $columnName->getName(), $this->total);
        }

        return sprintf("->%s('%s')", $this->getName(), $columnName->getName());
    }

    abstract protected function getName(): string;
}
