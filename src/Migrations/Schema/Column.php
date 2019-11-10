<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class Column
{
    private const RESERVED_COLUMN_TYPE = '__reserved_column_type';

    private $name;
    private $type;
    private $args;
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
            $this->name = self::RESERVED_COLUMN_TYPE;
            $this->type = 'rememberToken';
        } elseif ($name === 'softDeletes') {
            $this->name = self::RESERVED_COLUMN_TYPE;
            $this->type = 'softDeletes';
            $this->args = $attributes['args'] ?? $attributes;
        } elseif ($name === 'softDeletesTz') {
            $this->name = self::RESERVED_COLUMN_TYPE;
            $this->type = 'softDeletesTz';
            $this->args = $attributes['args'] ?? $attributes;
        } elseif ($name === 'timestamps') {
            $this->name = self::RESERVED_COLUMN_TYPE;
            $this->type = 'timestamps';
            $this->args = $attributes['args'] ?? $attributes;
        } elseif ($name === 'timestampsTz') {
            $this->name = self::RESERVED_COLUMN_TYPE;
            $this->type = 'timestampsTz';
            $this->args = $attributes['args'] ?? $attributes;
        } elseif (is_string($attributes)) {
            $this->type = $attributes;
        } elseif (is_array($attributes)) {
            $this->type = $attributes['type'];
            $this->args = $attributes['args'] ?? null;
            $this->after = $attributes['after'] ?? null;
            $this->autoIncrement = $attributes['autoIncrement'] ?? null;
            $this->charset = $attributes['charset'] ?? null;
            $this->collation = $attributes['collation'] ?? null;
            $this->comment = $attributes['comment'] ?? null;
            $this->default = $attributes['default'] ?? null;
            $this->first = $attributes['first'] ?? null;
            $this->nullable = $attributes['nullable'] ?? null;
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
     * @return bool
     */
    public function existsDefaultRaw(): bool
    {
        return isset($this->default['raw']);
    }

    /**
     * @return string
     */
    public function getColumnLine(): string
    {
        $str = $this->getColumnType();
        $str .= $this->getColumnModifier();
        $str .= $this->getIndexType();

        return '$table' . $str . ';';
    }

    /**
     * @return string
     */
    protected function getColumnType(): string
    {
        if ($this->name === self::RESERVED_COLUMN_TYPE) {
            return Method::call($this->type, ...(array)$this->args);
        }

        if ($this->type === 'enum' || $this->type === 'set') {
            return Method::call($this->type, $this->name, (array)$this->args);
        }

        return Method::call($this->type, $this->name, ...(array)$this->args);
    }

    /**
     * @return string
     */
    protected function getColumnModifier(): string
    {
        $str = '';

        if ($this->autoIncrement) {
            $str .= Method::call('autoIncrement');
        }

        if ($this->charset) {
            $str .= Method::call('charset', $this->charset);
        }

        if ($this->collation) {
            $str .= Method::call('collation', $this->collation);
        }

        if ($this->comment) {
            $str .= Method::call('comment', $this->comment);
        }

        if ($this->default !== null) {
            $str .= Method::call('default', isset($this->default['raw']) ? Literal::raw($this->default['raw']) : $this->default);
        }

        if ($this->nullable !== null) {
            $str .= Method::call('nullable', ...$this->nullable ? [] : [false]);
        }

        if ($this->storedAs) {
            $str .= Method::call('storedAs', $this->storedAs);
        }

        if ($this->unsigned) {
            $str .= Method::call('unsigned');
        }

        if ($this->useCurrent) {
            $str .= Method::call('useCurrent');
        }

        if ($this->virtualAs) {
            $str .= Method::call('virtualAs', $this->virtualAs);
        }

        if ($this->generatedAs) {
            $str .= Method::call('generatedAs', $this->generatedAs);
        }

        if ($this->always) {
            $str .= Method::call('always');
        }

        return $str;
    }

    /**
     * @return string
     */
    protected function getIndexType(): string
    {
        $str = '';

        if ($this->primary) {
            $str .= Method::call('primary');
        }

        if ($this->unique) {
            $str .= Method::call('unique');
        }

        if ($this->index) {
            $str .= Method::call('index');
        }

        if ($this->spatialIndex) {
            $str .= Method::call('spatialIndex');
        }

        return $str;
    }
}
