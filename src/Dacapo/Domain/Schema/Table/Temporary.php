<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;

final class Temporary
{
    /**
     * Temporary constructor.
     * @param bool $enable
     */
    public function __construct(private bool $enable)
    {
    }

    /**
     * @return string
     */
    public function makeMigration(): string
    {
        if ($this->enable) {
            return '$table->temporary();' . PHP_EOL . MigrationFile::MIGRATION_COLUMN_INDENT;
        }

        return '';
    }
}
