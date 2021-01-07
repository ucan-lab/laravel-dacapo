<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

use ArrayIterator;
use IteratorAggregate;

class SchemaFileList implements IteratorAggregate
{
    protected array $attributes = [];

    /**
     * SchemaFileList constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @param SchemaFile $file
     * @return SchemaFileList
     */
    public function add(SchemaFile $file): self
    {
        $this->attributes[] = $file;

        return $this;
    }

    /**
     * @return SchemaFile[] | ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
