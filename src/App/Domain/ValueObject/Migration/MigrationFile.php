<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration;

class MigrationFile
{
    protected string $name;
    protected string $contents;

    /**
     * MigrationFile constructor.
     * @param string $name
     * @param string $contents
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
