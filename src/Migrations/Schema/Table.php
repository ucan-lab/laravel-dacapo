<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use Illuminate\Support\Str;

class Table
{
    const PREFIX_CREATE_TABLE = '1970_01_01_000000'; // unix time 0
    const PREFIX_CONSTRAINT_RELATION = '1970_01_01_000001';
    const PREFIX_CREATE_INDEX = '1970_01_01_000002';

    private $name;
    private $attributes;
    private $connection;
    private $comment;
    private $engine;
    private $charset;
    private $collation;
    private $columns;
    private $indexes;
    private $relations;

    /**
     * @param string $name
     * @param array $attributes
     */
    public function __construct(string $name, array $attributes)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->connection = $attributes['connection'] ?? '';
        $this->comment = $attributes['comment'] ?? '';
        $this->engine = $attributes['engine'] ?? '';
        $this->charset = $attributes['charset'] ?? '';
        $this->collation = $attributes['collation'] ?? '';
        $this->columns = new Columns($attributes['columns'] ?? []);
        $this->indexes = new Indexes($this->name, $attributes['indexes'] ?? []);
        $this->relations = new Relations($attributes['relations'] ?? []);
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
    public function getCreateTableMigrationNamespace(): string
    {
        $namespace = '';
        if ($this->comment || $this->columns->hasDefaultRaw()) {
            $namespace = 'use Illuminate\Support\Facades\DB;' . PHP_EOL;
        }

        $namespace .= 'use Illuminate\Support\Facades\Schema;';
        $namespace .= PHP_EOL . 'use Illuminate\Database\Schema\Blueprint;';
        $namespace .= PHP_EOL . 'use Illuminate\Database\Migrations\Migration;';

        return $namespace;
    }

    /**
     * @return string
     */
    public function getTableComment(): string
    {
        if ($this->comment) {
            $prefix = PHP_EOL . PHP_EOL . '        ';
            if (config('database.default') === 'mysql') {
                return $prefix . sprintf('DB::statement("ALTER TABLE %s COMMENT \'%s\'");', $this->name, $this->comment);
            } elseif (config('database.default') === 'pgsql') {
                return $prefix . sprintf('DB::statement("COMMENT ON TABLE %s IS \'%s\';");', $this->name, $this->comment);
            }
        }

        return '';
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
        return self::PREFIX_CREATE_TABLE . '_create_' . $this->name . '_table.php';
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
        return self::PREFIX_CREATE_INDEX . '_create_' . $this->name . '_index.php';
    }

    /**
     * @return string
     */
    public function getConstraintRelationMigrationClassName(): string
    {
        return Str::studly('constraint_' . $this->name . '_relation');
    }

    /**
     * @return string
     */
    public function getConstraintRelationMigrationFileName(): string
    {
        return self::PREFIX_CONSTRAINT_RELATION . '_constraint_' . $this->name . '_relation.php';
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
    public function getCreateTableMigration(): string
    {
        if ($this->connection) {
            return sprintf("Schema::connection('%s')->create", $this->connection);
        }

        return 'Schema::create';
    }

    /**
     * @return string
     */
    public function getDropTableMigration(): string
    {
        if ($this->connection) {
            return sprintf("Schema::connection('%s')->dropIfExists", $this->connection);
        }

        return 'Schema::dropIfExists';
    }

    public function getTableMigration(): string
    {
        if ($this->connection) {
            return sprintf("Schema::connection('%s')->table", $this->connection);
        }

        return 'Schema::table';
    }

    /**
     * @return string
     */
    public function getUpIndexList(): string
    {
        $list = [];
        foreach ($this->indexes as $index) {
            if ($line = $index->getUpLine()) {
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
        foreach ($this->indexes as $index) {
            if ($line = $index->getDownLine()) {
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
        foreach ($this->relations as $foreignKey) {
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
        foreach ($this->relations as $relation) {
            if ($line = $relation->getDownForeignKeyLine()) {
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
    public function existsRelations(): bool
    {
        return $this->relations->count() > 0;
    }
}
