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

    /**
     * @param string $name
     * @param array|string $attributes
     */
    public function __construct(string $name, $attributes)
    {
        $this->name = $name;

        if ($name === 'rememberToken') {
            $this->name = null;
            $this->type = 'rememberToken';
        } elseif ($name === 'timestamps') {
            $this->name = is_int($attributes) ? $attributes : null;
            $this->type = 'timestamps';
        } elseif (is_string($attributes)) {
            $this->type = $attributes;
        } elseif (is_array($attributes)) {
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
    }

    /**
     * @return string
     */
    public function getColumnLine(): string
    {
        $str = $this->getColumnType();
        $str .= $this->getColumnModifier();

        return '$table' . $str . ';';
    }

    /**
     * @return string
     */
    protected function getColumnType(): string
    {
        if ($this->type === 'rememberToken') {
            return '->rememberToken()';
        } elseif ($this->type === 'timestamps') {
            return '->timestamps(' . ($this->name ?: '') . ')';
        }

        preg_match('/\((.*)\)/', $this->type, $match);
        $digits = isset($match[1]) ? $match[1] : 0;

        $columnName = "'$this->name'";

        if ($digits) {
            $columnName .= ', ' . $digits;
        }

        $type = substr($this->type, 0, strcspn($this->type, '('));
        return '->' . $type . "($columnName)";
    }

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    protected function getDropIndexType(): string
    {
        $str = '';

        if ($this->primary) {
            $str = "->dropPrimary(['$this->name'])";
        } elseif ($this->unique) {
            $str = "->dropUnique(['$this->name'])";
        } elseif ($this->index) {
            $str = "->dropIndex(['$this->name'])";
        } elseif ($this->spatialIndex) {
            $str = "->dropSpatialIndex(['$this->name'])";
        }

        return $str;
    }

    /**
     * @return string
     * @todo refactor later
     */
    protected function getColumnModifier(): string
    {
        $str = '';

//        if ($this->after) {
//            $str .= "->after('$this->after')";
//        }

        if ($this->autoIncrement) {
            $str .= "->autoIncrement()";
        }

        if ($this->charset) {
            $str .= "->charset('$this->charset')";
        }

        if ($this->collation) {
            $str .= "->collation('$this->collation')";
        }

        if ($this->comment) {
            $str .= "->comment('$this->comment')";
        }

        if ($this->default) {
            $str .= "->comment('$this->default')";
        }

//        if ($this->first) {
//            $str .= "->first()";
//        }

        if ($this->nullable !== null) {
            $str .= "->nullable($this->nullable)";
        }

        if ($this->storedAs) {
            $str .= "->storedAs('$this->storedAs')";
        }

        if ($this->unsigned) {
            $str .= "->unsigned()";
        }

        if ($this->useCurrent) {
            $str .= "->useCurrent()";
        }

        if ($this->virtualAs) {
            $str .= "->virtualAs('$this->virtualAs')";
        }

        if ($this->generatedAs) {
            $str .= "->generatedAs('$this->generatedAs')";
        }

        if ($this->always) {
            $str .= "->always()";
        }

        return $str;
    }

    /**
     * @param array $attributes
     * @param string $name
     * @return string|null
     */
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
