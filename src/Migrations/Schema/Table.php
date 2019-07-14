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

        if (isset($attributes['foreignKeys'])) {
            foreach ($attributes['foreignKeys'] as $i => $foreignKeyAttributes) {
                $foreignKey = $this->makeForeignKey($foreignKeyAttributes);
                $this->foreignKeys->add($foreignKey);
            }
        }
    }

    public function getTableName(): string
    {
        return $this->name;
    }

    public function getTableComment(): string
    {
        return $this->comment;
    }

    public function getCreateTableMigrationClassName(): string
    {
        return Str::studly('create_' . $this->name . '_table');
    }

    public function getCreateTableMigrationFileName(): string
    {
        return $this->getDatePrefix() . '_create_' . $this->name . '_table.php';
    }

    public function getCreateIndexMigrationClassName(): string
    {
        return Str::studly('create_' . $this->name . '_index');
    }

    public function getCreateIndexMigrationFileName(): string
    {
        return $this->getDatePrefix(self::PREFIX_CREATE_INDEX) . '_create_' . $this->name . '_index.php';
    }

    public function getConstraintForeignKeyMigrationClassName(): string
    {
        return Str::studly('constraint_' . $this->name . '_foreign_key');
    }

    public function getConstraintForeignKeyMigrationFileName(): string
    {
        return $this->getDatePrefix(self::PREFIX_CONSTRAINT_FOREIGN_KEY) . '_constraint_' . $this->name . '_foreign_key.php';
    }

    public function getColumnList(): string
    {
        $list = [];
        foreach ($this->columns as $column) {
            $list[] = $column->getColumnLine();
        }

        $spacer = PHP_EOL . '            ';

        return implode($spacer, $list);
    }

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

    public function existsIndexModifiers(): bool
    {
        return $this->indexes->count() > 0;
    }

    public function existsForeignKeys(): bool
    {
        return $this->foreignKeys->count() > 0;
    }

    protected function makeColumn(string $name, $attributes): Column
    {
        if ($attributes === 'increments') {
            return new Column($name, ['type' => 'increments']);
        } elseif ($attributes === 'bigIncrements') {
            return new Column($name, ['type' => 'bigIncrements']);
        }

        return new Column($name, $attributes);
    }

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
