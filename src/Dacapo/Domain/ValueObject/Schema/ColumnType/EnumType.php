<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class EnumType implements ColumnType
{
    /**
     * @var array
     */
    protected array $args;

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
        return sprintf("->enum('%s', ['%s'])", $columnName->getName(), implode("', '", $this->args));
    }
}
