<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;
use Exception;

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
        if (is_array($this->args)) {
            return sprintf("->enum('%s', ['%s'])", $columnName->getName(), implode("', '", $this->args));
        }

        throw new Exception('Not support EnumType $args');
    }
}
