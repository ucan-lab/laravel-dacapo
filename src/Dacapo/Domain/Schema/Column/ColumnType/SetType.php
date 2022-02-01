<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;

final class SetType implements ColumnType
{
    /**
     * @var array
     */
    private array $args;

    public function __construct(array $args)
    {
        $this->args = $args;
    }

    /**
     * @param ColumnName $columnName
     * @return string
     * @throws
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        return sprintf("->set('%s', ['%s'])", $columnName->getName(), implode("', '", $this->args));
    }
}
