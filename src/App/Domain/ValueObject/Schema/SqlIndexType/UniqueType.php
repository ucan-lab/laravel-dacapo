<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndexType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndex;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndexType;

class UniqueType implements SqlIndexType
{
    /**
     * @param SqlIndex $index
     * @return string
     */
    public function createIndexMigrationUpMethod(SqlIndex $index): string
    {
        $args[] = $index->getColumns();

        if ($index->getName()) {
            $args[] = sprintf("'%s'", $index->getName());
        }

        if ($index->getAlgorithm()) {
            $args[] = sprintf("'%s'", $index->getAlgorithm());
        }

        return sprintf("->unique(%s)", implode(', ', $args));
    }

    /**
     * @param SqlIndex $index
     * @return string
     */
    public function createIndexMigrationDownMethod(SqlIndex $index): string
    {
        if ($index->getName()) {
            return sprintf("->dropUnique('%s')", $index->getName());
        }

        return sprintf("->dropUnique(%s)", $index->getColumns());
    }
}
