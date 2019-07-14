<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class Column
{
    private $name;
    private $type;
    // column modifiers
    private $after;
    private $autoIncrement;
    private $charset;
    private $collation;
    private $comment;
    private $default;
    private $first;
    private $nullable;
    private $storedAs;
    private $unsigned;
    private $useCurrent;
    private $virtualAs;
    private $generatedAs;
    private $always;
    // index modifiers
    private $primary;
    private $unique;
    private $index;
    private $spatialIndex;

    public function __construct(string $name, array $attributes)
    {
        $this->name = $name;
        $this->type = $attributes['type'];
        $this->after = $attributes['after'] ?? null;
        $this->autoIncrement = $attributes['autoIncrement'] ?? null;
        $this->charset = $attributes['charset'] ?? null;
        $this->collation = $attributes['collation'] ?? null;
        $this->comment = $attributes['comment'] ?? null;
        $this->default = $attributes['default'] ?? null;
        $this->first = $attributes['first'] ?? null;
        $this->nullable = $this->convertBoolType($attributes, 'nullable');
        $this->storedAs = $attributes['storedAs'] ?? null;
        $this->unsigned = $attributes['unsigned'] ?? null;
        $this->useCurrent = $attributes['useCurrent'] ?? null;
        $this->virtualAs = $attributes['virtualAs'] ?? null;
        $this->generatedAs = $attributes['generatedAs'] ?? null;
        $this->always = $attributes['always'] ?? null;
        $this->primary = $attributes['primary'] ?? null;
        $this->unique = $attributes['unique'] ?? null;
        $this->index = $attributes['index'] ?? null;
        $this->spatialIndex = $attributes['spatialIndex'] ?? null;
    }

    public function getColumnLine(): string
    {
        $str = $this->getColumnType();
        $str .= $this->getColumnModifier();

        return '$table' . $str . ';';
    }

    public function hasIndex(): bool
    {
        return (bool)($this->primary || $this->unique || $this->index || $this->spatialIndex);
    }

    public function getIndex(): Index
    {
        $attributes = ['name' => [$this->name]];
        if ($this->primary) {
            $attributes['primary'] = true;
        } elseif ($this->unique) {
            $attributes['unique'] = true;
        } elseif ($this->index) {
            $attributes['index'] = true;
        } elseif ($this->spatialIndex) {
            $attributes['spatialIndex'] = true;
        }

        return new Index($attributes);
    }

    public function getUpIndexLine(): ?string
    {
        if ($str = $this->getIndexType()) {
            return '$table' . $str . ';';
        }

        return null;
    }

    public function getDownIndexLine(): ?string
    {
        if ($str = $this->getDropIndexType()) {
            return '$table' . $str . ';';
        }

        return null;
    }

    protected function getColumnType(): string
    {
        preg_match('/\((.*)\)/', $this->type, $match);
        $digits = isset($match[1]) ? $match[1] : 0;

        $columnName = "'$this->name'";

        if ($digits) {
            $columnName .= ', ' . $digits;
        }

        $type = substr($this->type, 0, strcspn($this->type, '('));
        return '->' . $type . "($columnName)";
    }

    protected function getIndexType(): string
    {
        $str = '';

        if ($this->primary) {
            $str = "->primary('$this->name')";
        } elseif ($this->unique) {
            $str = "->unique('$this->name')";
        } elseif ($this->index) {
            $str = "->index('$this->name')";
        } elseif ($this->spatialIndex) {
            $str = "->spatialIndex('$this->name')";
        }

        return $str;
    }

    protected function getDropIndexType(): string
    {
        $str = '';

        if ($this->primary) {
            $str = "->dropPrimary('$this->name')";
        } elseif ($this->unique) {
            $str = "->dropUnique('$this->name')";
        } elseif ($this->index) {
            $str = "->dropIndex('$this->name')";
        } elseif ($this->spatialIndex) {
            $str = "->dropSpatialIndex('$this->name')";
        }

        return $str;
    }

    protected function getColumnModifier(): string
    {
        $str = '';

        if ($this->after) {
            //
        } elseif ($this->autoIncrement) {
            //
        } elseif ($this->charset) {
            //
        } elseif ($this->collation) {
            //
        } elseif ($this->comment) {
            $str .= "->comment('$this->comment')";
        } elseif ($this->default) {
            $str .= "->comment('$this->default')";
        } elseif ($this->first) {
            //
        } elseif ($this->nullable !== null) {
            $str .= "->nullable($this->nullable)";
        } elseif ($this->storedAs) {
            //
        } elseif ($this->unsigned) {
            $str .= "->unsigned()";
        } elseif ($this->useCurrent) {
            //
        } elseif ($this->virtualAs) {
            //
        } elseif ($this->generatedAs) {
            //
        } elseif ($this->always) {
            //
        }

        return $str;
    }

    private function convertBoolType(array $attributes, string $name): ?string
    {
        if (isset($attributes[$name])) {
            if ($attributes[$name]) {
                return 'true';
            }
            return 'false';
        }

        return null;
    }
}
