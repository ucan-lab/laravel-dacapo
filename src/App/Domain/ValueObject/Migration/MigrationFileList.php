<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class MigrationFileList implements IteratorAggregate, Countable
{
    protected array $attributes = [];

    /**
     * MigrationFileList constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $file) {
            $this->attributes[$file->getName()] = $file;
        }

        ksort($this->attributes);
    }

    /**
     * @param MigrationFile $file
     * @return MigrationFileList
     */
    public function add(MigrationFile $file): self
    {
        $this->attributes[$file->getName()] = $file;
        ksort($this->attributes);

        return $this;
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
     * @return MigrationFile[] | ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
