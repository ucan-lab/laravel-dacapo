<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class Column
{
    const RESERVED_COLUMN_TYPE = '__reserved_column_type';

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
            if (is_null($this->args)) {
                return sprintf('->%s()', $this->type);
            }

            return sprintf('->%s(%s)', $this->type, $this->convertArgs());
        } elseif ($this->type === 'enum') {
            return sprintf("->%s('%s', [%s])", $this->type, $this->name, $this->convertArgsToArray());
        } elseif ($this->type === 'set') {
            return sprintf("->%s('%s', [%s])", $this->type, $this->name, $this->convertArgsToArray());
        } elseif (is_null($this->args)) {
            return sprintf("->%s('%s')", $this->type, $this->name);
        } else {
            return sprintf("->%s('%s'%s)", $this->type, $this->name, $this->convertArgs(true));
        }
    }

    /**
     * @return string
     * @todo refactor later
     */
    protected function getColumnModifier(): string
    {
        $str = '';

        if ($this->autoIncrement) {
            $str .= '->autoIncrement()';
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

        if ($this->default !== null) {
            $str .= sprintf('->default(%s)', isset($this->default['raw']) ? Literal::raw($this->default['raw']) : Literal::of($this->default));
        }

        if ($this->nullable !== null) {
            $str .= "->nullable($this->nullable)";
        }

        if ($this->storedAs) {
            $str .= "->storedAs('$this->storedAs')";
        }

        if ($this->unsigned) {
            $str .= '->unsigned()';
        }

        if ($this->useCurrent) {
            $str .= '->useCurrent()';
        }

        if ($this->virtualAs) {
            $str .= "->virtualAs('$this->virtualAs')";
        }

        if ($this->generatedAs) {
            $str .= "->generatedAs('$this->generatedAs')";
        }

        if ($this->always) {
            $str .= '->always()';
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
            $str .= '->primary()';
        }

        if ($this->unique) {
            $str .= '->unique()';
        }

        if ($this->index) {
            $str .= '->index()';
        }

        if ($this->spatialIndex) {
            $str .= '->spatialIndex()';
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
                return '';
            }

            return 'false';
        }

        return null;
    }

    /**
     * @return string
     */
    private function convertArgsToArray(): string
    {
        $str = '';
        foreach ($this->args as $arg) {
            $str .= ', ' . var_export($arg, true);
        }

        return ltrim($str, ', ');
    }

    /**
     * @param bool $prefix
     * @return string
     */
    private function convertArgs(bool $prefix = false): string
    {
        $str = '';
        if (is_null($this->args)) {
            return '';
        } elseif (is_array($this->args)) {
            foreach ($this->args as $arg) {
                $str .= ', ' . var_export($arg, true);
            }
        } else {
            $str = ', ' . var_export($this->args, true);
        }

        if (! $prefix) {
            return ltrim($str, ', ');
        }

        return $str;
    }
}
