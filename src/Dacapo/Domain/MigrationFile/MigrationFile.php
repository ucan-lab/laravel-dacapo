<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile;

final class MigrationFile
{
    public const MIGRATION_COLUMN_INDENT = '            ';

    /**
     * MigrationFile constructor.
     */
    private function __construct(
        private string $name,
        private string $contents,
    ) {
    }

    /**
     * @return $this
     */
    public static function factory(string $name, string $contents): self
    {
        return new self($name, $contents);
    }

    /**
     * @return $this
     */
    public function replace(string $placeholder, string $value): self
    {
        $this->contents = str_replace($placeholder, $value, $this->contents);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContents(): string
    {
        return $this->contents;
    }
}
