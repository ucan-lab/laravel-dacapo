<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Migration;

final class MigrationFile
{
    private string $name;
    private string $contents;

    /**
     * MigrationFile constructor.
     * @param string $name
     * @param string $contents
     * @throws
     */
    public function __construct(string $name, string $contents)
    {
        $this->name = $name;
        $this->contents = $contents;
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
