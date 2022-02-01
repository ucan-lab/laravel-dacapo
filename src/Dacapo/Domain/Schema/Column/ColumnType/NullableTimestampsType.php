<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use function is_int;

final class NullableTimestampsType implements ColumnType
{
    /**
     * @var int|null
     */
    private ?int $args;

    public function __construct(?int $args = null)
    {
        $this->args = $args;
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if (is_int($this->args)) {
            return sprintf('->nullableTimestamps(%d)', $this->args);
        }

        return '->nullableTimestamps()';
    }
}
