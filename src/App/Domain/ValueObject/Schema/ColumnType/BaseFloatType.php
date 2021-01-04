<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

abstract class BaseFloatType implements ColumnType
{
    protected ?int $total = null;
    protected ?int $places = null;

    public function __construct($args = null)
    {
        if (is_string($args) && $args !== '') {
            $args = explode(',', $args);
        }

        if (is_array($args) && count($args) === 2) {
            $this->total = (int) $args[0];
            $this->places = (int) $args[1];
        } elseif (is_array($args) && count($args) === 1) {
            $this->total = (int) $args[0];
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
