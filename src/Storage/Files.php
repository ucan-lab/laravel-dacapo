<?php

namespace UcanLab\LaravelDacapo\Storage;

use ArrayIterator;
use IteratorAggregate;
use SplFileInfo;

class Files implements IteratorAggregate
{
    private $attributes;

    public function __construct()
    {
        $this->attributes = [];
    }

    /**
     * @param SplFileInfo $file
     * @return self
     */
    public function add(SplFileInfo $file): self
    {
        $this->attributes[] = $file;
        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->attributes;
    }

    /**
     * @return integer
     */
    public function count(): int
    {
        if ($this->attributes) {
            return count($this->attributes);
        }

        return 0;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
