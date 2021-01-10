<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class MorphsType implements ColumnType
{
    /**
     * @var string|null
     */
    protected ?string $args;

    public function __construct(?string $args = null)
    {
        $this->args = $args;
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if ($this->args) {
            return sprintf("->morphs('%s', '%s')", $columnName->getName(), $this->args);
        }

        return sprintf("->morphs('%s')", $columnName->getName());
    }
}
