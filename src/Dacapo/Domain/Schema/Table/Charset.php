<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;

final class Charset
{
    /**
     * Charset constructor.
     */
    public function __construct(private ?string $value)
    {
    }

    public function makeMigration(): string
    {
        if ($this->value !== null) {
            return sprintf("\$table->charset = '%s';", $this->value) . PHP_EOL . MigrationFile::MIGRATION_COLUMN_INDENT;
        }

        return '';
    }
}
