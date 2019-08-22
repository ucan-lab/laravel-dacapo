<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use Illuminate\Support\Str;

class Table
{
    const PREFIX_CREATE_TABLE = 0;
    const PREFIX_CREATE_INDEX = 1;
    const PREFIX_CONSTRAINT_FOREIGN_KEY = 2;

    private $name;
    private $comment;
    private $engine;
    private $charset;
    private $collation;
    private $timestamps;
    private $columns;
    private $indexes;
    private $foreignKeys;

    /**
     * @param string $name
     * @param array $attributes
     */
    public function __construct(string $name, array $attributes)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->comment = $attributes['comment'] ?? '';
        $this->engine = $attributes['engine'] ?? '';
        $this->charset = $attributes['charset'] ?? '';
        $this->collation = $attributes['collation'] ?? '';
        $this->timestamps = $attributes['timestamps'] ?? '';
        $this->columns = new Columns();
        $this->indexes = new Indexes();
        $this->foreignKeys = new ForeignKeys();

        if (isset($attributes['indexes'])) {
            foreach ($attributes['indexes'] as $indexAttributes) {
                $indexes = $this->makeColumn($indexAttributes);
                $this->indexes->add($index);
            }
        }

        if (isset($attributes['columns'])) {
            foreach ($attributes['columns'] as $columnName => $columnAttributes) {
                $column = $this->makeColumn($columnName, $columnAttributes);
                $this->columns->add($column);

                if ($column->hasIndex()) {
                    $this->indexes->add($column->getIndex());
                }
            }
        }

        if (isset($attributes['relations'])) {
            foreach ($attributes['relations'] as $i => $foreignKeyAttributes) {
                $foreignKey = $this->makeForeignKey($foreignKeyAttributes);
                $this->foreignKeys->add($foreignKey);
            }
        }
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getModelName(): string
    {
        return Str::studly(Str::singular($this->name));
    }

    /**
     * @return string
     */
    public function getTableComment(): string
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getCreateTableMigrationClassName(): string
    {
        return Str::studly('create_' . $this->name . '_table');
    }

    /**
     * @return string
     */
    public function getCreateTableMigrationFileName(): string
    {
        return $this->getDatePrefix() . '_create_' . $this->name . '_table.php';
    }

    /**
     * @return string
     */
    public function getCreateIndexMigrationClassName(): string
    {
        return Str::studly('create_' . $this->name . '_index');
    }

    /**
     * @return string
     */
    public function getCreateIndexMigrationFileName(): string
    {
        return $this->getDatePrefix(self::PREFIX_CREATE_INDEX) . '_create_' . $this->name . '_index.php';
    }

    /**
     * @return string
     */
    public function getConstraintForeignKeyMigrationClassName(): string
    {
        return Str::studly('constraint_' . $this->name . '_foreign_key');
    }

    /**
     * @return string
     */
    public function getConstraintForeignKeyMigrationFileName(): string
    {
        return $this->getDatePrefix(self::PREFIX_CONSTRAINT_FOREIGN_KEY) . '_constraint_' . $this->name . '_foreign_key.php';
    }

    /**
     * @return string
     */
    public function getColumnList(): string
    {
        $list = [];
        foreach ($this->columns as $column) {
            $list[] = $column->getColumnLine();
        }

        $spacer = PHP_EOL . '            ';

        return implode($spacer, $list);
    }

    /**
     * @return string
     */
    public function getUpIndexList(): string
    {
        $list = [];
        foreach ($this->columns as $column) {
            if ($line = $column->getUpIndexLine()) {
                $list[] = $line;
            }
        }

        $spacer = PHP_EOL . '            ';

        return implode($spacer, $list);
    }

    /**
     * @return string
     */
    public function getDownIndexList(): string
    {
        $list = [];
        foreach ($this->columns as $column) {
            if ($line = $column->getDownIndexLine()) {
                $list[] = $line;
            }
        }

        $spacer = PHP_EOL . '            ';

        return implode($spacer, $list);
    }

    /**
     * @return string
     */
    public function getUpForeignKeyList(): string
    {
        $list = [];
        foreach ($this->foreignKeys as $foreignKey) {
            if ($line = $foreignKey->getUpForeignKeyLine()) {
                $list[] = $line;
            }
        }

        $spacer = PHP_EOL . '            ';

        return implode($spacer, $list);
    }

    /**
     * @return string
     */
    public function getDownForeignKeyList(): string
    {
        $list = [];
        foreach ($this->foreignKeys as $foreignKey) {
            if ($line = $foreignKey->getDownForeignKeyLine()) {
                $list[] = $line;
            }
        }

        $spacer = PHP_EOL . '            ';

        return implode($spacer, $list);
    }

    /**
     * @return bool
     */
    public function existsIndexModifiers(): bool
    {
        return $this->indexes->count() > 0;
    }

    /**
     * @return bool
     */
    public function existsForeignKeys(): bool
    {
        return $this->foreignKeys->count() > 0;
    }

    /**
     * @param string $name
     * @param string|array $attributes
     * @return Column
     */
    protected function makeColumn(string $name, $attributes): Column
    {
        if (is_string($attributes)) {
            return new Column($name, ['type' => $attributes]);
        }

        return new Column($name, $attributes);
    }

    /**
     * @param array $attributes
     * @return ForeignKey
     */
    protected function makeForeignKey(array $attributes): ForeignKey
    {
        return new ForeignKey($attributes);
    }

    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix(int $time = self::PREFIX_CREATE_TABLE): string
    {
        return date('Y_m_d_His', $time);
    }
}
