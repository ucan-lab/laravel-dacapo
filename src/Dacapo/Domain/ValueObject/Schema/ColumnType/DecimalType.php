<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class DecimalType implements ColumnType
{
    protected ?int $total = null;
    protected ?int $places = null;
    protected ?bool $unsigned = null;

    public function __construct($args = null)
    {
        if (is_string($args) && $args !== '') {
            $args = array_map('trim', explode(',', $args));
        }

        if (is_array($args)) {
            $this->total = isset($args[0]) ? (int) $args[0] : null;
            $this->places = isset($args[1]) ? (int) $args[1] : null;

            if (isset($args[2])) {
                if (is_string($args[2])) {
                    $this->unsigned = $args[2] === 'true';
                } else {
                    $this->unsigned = $args[2];
                }
            }
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
            return sprintf("->decimal('%s', %d, %d, %s)", $columnName->getName(), $this->total, $this->places, $this->unsigned ? 'true' : 'false');
        } elseif (is_int($this->total) && is_int($this->places)) {
            return sprintf("->decimal('%s', %d, %d)", $columnName->getName(), $this->total, $this->places);
        } elseif (is_int($this->total) && is_int($this->places) === false) {
            return sprintf("->decimal('%s', %d)", $columnName->getName(), $this->total);
        }

        return sprintf("->decimal('%s')", $columnName->getName());
    }
}
