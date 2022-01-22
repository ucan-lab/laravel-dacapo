<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

final class UuidMorphsType implements ColumnType
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
            return sprintf("->uuidMorphs('%s', '%s')", $columnName->getName(), $this->args);
        }

        return sprintf("->uuidMorphs('%s')", $columnName->getName());
    }
}
