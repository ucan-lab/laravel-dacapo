<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use function count;

/**
 * @implements IteratorAggregate<MigrationFile>
 */
final class MigrationFileList implements IteratorAggregate, Countable
{
    /**
     * @var array<int, MigrationFile>
     */
    private array $attributes;

    /**
     * @param array<int, MigrationFile> $attributes
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $migrationFile) {
            $this->attributes[$migrationFile->getName()] = $migrationFile;
        }
    }

    /**
     * @return array<int, MigrationFile>
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
     * @return ArrayIterator<int, MigrationFile>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
