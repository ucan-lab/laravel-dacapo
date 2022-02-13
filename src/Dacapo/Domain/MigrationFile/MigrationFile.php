<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile;

final class MigrationFile
{
    /**
     * MigrationFile constructor.
     * @param string $name
     * @param string $contents
     */
    public function __construct(
        private string $name,
        private string $contents,
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
    }
}
