<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;
use Exception;

class SetType implements ColumnType
{
    /**
     * @param ColumnName $columnName
     * @return string
     * @throws
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        $args = $columnName->getArgs();

        if (is_array($args)) {
            return sprintf("->set('%s', ['%s'])", $columnName->getName(), implode("', '", $args));
        }

        throw new Exception('Not support EnumType $args');
    }
}
