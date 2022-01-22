<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

final class MorphsType implements ColumnType
{
    /**
     * @var string|null
     */
    private ?string $args;

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
