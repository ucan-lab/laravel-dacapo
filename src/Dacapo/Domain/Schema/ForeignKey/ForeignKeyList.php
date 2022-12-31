<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;

final class ForeignKeyList
{
    /**
     * @param array<int, ForeignKey> $attributes
     */
    public function __construct(private array $attributes)
    {
    }

    public function exists(): bool
    {
        return ! (empty($this->attributes));
    }

    public function makeUpMigration(): string
    {
        $str = '';

        foreach ($this->attributes as $foreignKey) {
            $str .= $foreignKey->makeUpMigration() . PHP_EOL . MigrationFile::MIGRATION_COLUMN_INDENT;
        }

        return trim($str);
    }

    public function makeDownMigration(): string
    {
        $str = '';

        foreach ($this->attributes as $foreignKey) {
            $str .= $foreignKey->makeDownMigration() . PHP_EOL . MigrationFile::MIGRATION_COLUMN_INDENT;
        }

        return trim($str);
    }
}
