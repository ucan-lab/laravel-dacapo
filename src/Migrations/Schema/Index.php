<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use Exception;

class Index
{
    private $tableName;
    private $columns;
    private $alias;
    private $type;

    /**
     * @param string $tableName
     * @param array $attributes
     */
    public function __construct(string $tableName, array $attributes)
    {
        $this->tableName = $tableName;
        $this->columns = $attributes['columns'];
        $this->alias = $attributes['alias'] ?? null;
        $this->type = $attributes['type'];
    }

    /**
     * @return string
     */
    public function getUpLine(): string
    {
        $str = $this->makeIndex();

        return '$table' . $str . ';';
    }

    /**
     * @return string
     */
    public function getDownLine(): string
    {
        $str = $this->makeDropIndex();

        return '$table' . $str . ';';
    }

    /**
     * @return string
     * @throws
     */
    private function makeIndex(): string
    {
        if ($this->alias) {
            return sprintf(
                "->%s(%s, '%s')",
                $this->type,
                $this->makeColumns(),
                $this->alias
            );
        }

        return sprintf(
            '->%s(%s)',
            $this->type,
            $this->makeColumns()
        );
    }

    /**
     * @return string
     * @throws
     */
    private function makeDropIndex(): string
    {
        if ($this->alias) {
            return sprintf(
                "->drop%s('%s')",
                ucfirst($this->type),
                $this->alias
            );
        }

        return sprintf(
            "->drop%s('%s')",
            ucfirst($this->type),
            $this->makeIndexName()
        );
    }

    /**
     * @return string
     * @throws
     */
    private function makeColumns(): string
    {
        if (is_string($this->columns)) {
            return "'$this->columns'";
        } elseif (is_array($this->columns)) {
            return "['" . implode("', '", $this->columns) . "']";
        }

        throw new Exception('Error index of columns.');
    }

    /**
     * @return string
     * @throws
     */
    private function makeIndexName(): string
    {
        return sprintf('%s_%s_%s',
            $this->tableName,
            is_array($this->columns) ? implode('_', $this->columns) : $this->columns,
            $this->type
        );
    }
}
