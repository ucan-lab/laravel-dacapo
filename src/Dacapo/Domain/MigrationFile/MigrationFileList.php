<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use function count;

final class MigrationFileList implements IteratorAggregate, Countable
{
    /**
     * @var array<string, MigrationFile>
     */
    private array $attributes;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $migrationFile) {
            $this->attributes[$migrationFile->getName()] = $migrationFile;
        }
    }

    /**
     * @return array<string, MigrationFile>
     */
    public function get(): array
    {
        return $this->attributes;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->attributes);
    }

    /**
     * @return bool
     */
    public function empty(): bool
    {
        return empty($this->attributes);
    }

    /**
     * @return MigrationFile[]|ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
