<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;
use function is_string;
use function is_array;
use function count;
use function is_bool;
use function is_int;

abstract class BaseDecimalType implements ColumnType
{
    private ?int $total = null;
    private ?int $places = null;
    private ?bool $unsigned = null;

    public function __construct($args = null)
    {
        if (is_string($args) && $args !== '') {
            $args = explode(',', $args);
        }

        if (is_array($args) && count($args) === 3) {
            $this->total = (int) $args[0];
            $this->places = (int) $args[1];

            if (is_string($args[2])) {
                $this->unsigned = (trim($args[2]) === 'true') ? true : false;
            } else {
                $this->unsigned = $args[2];
            }
        } elseif (is_array($args) && count($args) === 2) {
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
        if (is_int($this->total) && is_int($this->places) && is_bool($this->unsigned)) {
            return sprintf("->%s('%s', %d, %d, %s)", $this->getName(), $columnName->getName(), $this->total, $this->places, $this->unsigned ? 'true' : 'false');
        } elseif (is_int($this->total) && is_int($this->places)) {
            return sprintf("->%s('%s', %d, %d)", $this->getName(), $columnName->getName(), $this->total, $this->places);
        } elseif (is_int($this->total) && is_int($this->places) === false) {
            return sprintf("->%s('%s', %d)", $this->getName(), $columnName->getName(), $this->total);
        }

        return sprintf("->%s('%s')", $this->getName(), $columnName->getName());
    }

    abstract protected function getName(): string;
}
