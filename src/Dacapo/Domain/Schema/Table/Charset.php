<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;

final class Charset
{
    /**
     * Charset constructor.
     * @param string|null $value
     */
    public function __construct(private ?string $value)
    {
    }

    /**
     * @return string
     */
    public function makeMigration(): string
    {
        if ($this->value !== null) {
            return sprintf("\$table->charset = '%s';", $this->value) . PHP_EOL . MigrationFile::MIGRATION_COLUMN_INDENT;
        }

        return '';
    }
}
