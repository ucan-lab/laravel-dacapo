<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration;

use Exception;
use Illuminate\Support\Str;

class MigrationFile
{
    protected string $name;
    protected string $contents;

    /**
     * MigrationFile constructor.
     * @param string $name
     * @param string $contents
     * @throws
     */
    public function __construct(string $name, string $contents)
    {
        $this->validateName($name);

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

    /**
     * @param string $name
     * @throws Exception
     */
    protected function validateName(string $name): void
    {
        if (Str::startsWith($name, '1970_01_01') === false) {
            throw new Exception(sprintf('$name: %s must start with 1970_01_01.', $name));
        }
    }
}
