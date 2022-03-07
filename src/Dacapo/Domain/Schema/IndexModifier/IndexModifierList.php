<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;

final class IndexModifierList
{
    /**
     * @param array<int, IndexModifier> $attributes
     */
    public function __construct(private array $attributes)
    {
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return ! (empty($this->attributes));
    }

    /**
     * @return string
     */
    public function makeUpMigration(): string
    {
        $str = '';

        foreach ($this->attributes as $indexModifier) {
            $str .= $indexModifier->makeUpMigration() . PHP_EOL . MigrationFile::MIGRATION_COLUMN_INDENT;
        }

        return trim($str);
    }

    /**
     * @return string
     */
    public function makeDownMigration(): string
    {
        $str = '';

        foreach ($this->attributes as $indexModifier) {
            $str .= $indexModifier->makeDownMigration() . PHP_EOL . MigrationFile::MIGRATION_COLUMN_INDENT;
        }

        return trim($str);
    }
}
