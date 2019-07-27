<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class Index
{
    private $name;
    private $primary;
    private $unique;
    private $index;
    private $spatialIndex;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->name = $attributes['name'];
        $this->primary = $attributes['primary'] ?? null;
        $this->unique = $attributes['unique'] ?? null;
        $this->index = $attributes['index'] ?? null;
        $this->spatialIndex = $attributes['spatialIndex'] ?? null;
    }
}
