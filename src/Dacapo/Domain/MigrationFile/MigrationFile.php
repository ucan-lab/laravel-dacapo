<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile;

final class MigrationFile
{
    /**
     * MigrationFile constructor.
     * @param string $name
     * @param string $contents
     */
    private function __construct(
        private string $name,
        private string $contents,
    ) {
    }

    /**
     * @param string $name
     * @param string $contents
     * @return $this
     */
    public static function factory(string $name, string $contents): self
    {
        return new self($name, $contents);
    }

    /**
     * @param string $placeholder
     * @param string $value
     * @return $this
     */
    public function replace(string $placeholder, string $value): self
    {
        $this->contents = str_replace($placeholder, $value, $this->contents);

        return $this;
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
