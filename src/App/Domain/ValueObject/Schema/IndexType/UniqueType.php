<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\IndexType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Index;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\IndexType;

class UniqueType implements IndexType
{
    /**
     * @param Index $index
     * @return string
     */
    public function createIndexMigrationUpMethod(Index $index): string
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
     * @param Index $index
     * @return string
     */
    public function createIndexMigrationDownMethod(Index $index): string
    {
        if ($index->getName()) {
            return sprintf("->dropUnique('%s')", $index->getName());
        }

        return sprintf("->dropUnique(%s)", $index->getColumns());
    }
}
