<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\IndexType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Index;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\IndexType;

class SpatialIndexType implements IndexType
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

        return sprintf("->spatialIndex(%s)", implode(', ', $args));
    }

    /**
     * @param Index $index
     * @return string
     */
    public function createIndexMigrationDownMethod(Index $index): string
    {
        if ($index->getName()) {
            return sprintf("->dropSpatialIndex('%s')", $index->getName());
        }

        return sprintf("->dropSpatialIndex(%s)", $index->getColumns());
    }
}
