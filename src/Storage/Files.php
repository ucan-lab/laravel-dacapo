<?php

namespace UcanLab\LaravelDacapo\Storage;

use SplFileInfo;
use ArrayIterator;
use IteratorAggregate;

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
     * @return int
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
