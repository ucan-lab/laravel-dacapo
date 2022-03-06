<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Builder\DatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Stub\MigrationCreateStub;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Stub\MigrationUpdateStub;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\Column;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKey;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKeyList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Charset;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Collation;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Connection;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Engine;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Table;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\TableName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Temporary;

final class Schema
{
    private const MIGRATION_COLUMN_INDENT = '            ';

    /**
     * Schema constructor.
     * @param Table $table
     * @param ColumnList $columnList
     * @param IndexModifierList $sqlIndexList
     * @param ForeignKeyList $foreignKeyList
     */
    private function __construct(
        private Table $table,
        private ColumnList $columnList,
        private IndexModifierList $sqlIndexList,
        private ForeignKeyList $foreignKeyList,
    ) {
    }

    /**
     * @param TableName $tableName
     * @param array<string, mixed> $attributes
     * @return $this
     */
    public static function factory(TableName $tableName, array $attributes): self
    {
        $columnList = [];
        foreach ($attributes['columns'] ?? [] as $columnName => $columnAttributes) {
            $columnList[] = Column::factory(new ColumnName($columnName), $columnAttributes);
        }

        $indexModifierList = [];
        foreach ($attributes['indexes'] ?? [] as $indexModifierAttributes) {
            $indexModifierList[] = IndexModifier::factory($indexModifierAttributes);
        }

        $foreignKeyList = [];
        foreach ($attributes['foreign_keys'] ?? [] as $foreignKeyAttributes) {
            $foreignKeyList[] = ForeignKey::factory($foreignKeyAttributes);
        }

        return new self(
            Table::factory($tableName, $attributes),
            new ColumnList($columnList),
            new IndexModifierList($indexModifierList),
            new ForeignKeyList($foreignKeyList),
        );
    }

    /**
     * @param DatabaseBuilder $databaseBuilder
     * @param MigrationCreateStub $migrationCreateStub
     * @return MigrationFile
     */
    public function makeCreateTableMigrationFile(
        DatabaseBuilder $databaseBuilder,
        MigrationCreateStub $migrationCreateStub
    ): MigrationFile {
        $name = sprintf('1970_01_01_000001_create_%s_table.php', $this->getTableName());
        $contents = $migrationCreateStub->getStub();
        $contents = str_replace('{{ namespace }}', $this->makeMigrationNamespace(), $contents);
        $contents = str_replace('{{ connection }}', $this->getConnection()->makeMigration(), $contents);
        $contents = str_replace('{{ tableName }}', $this->getTableName(), $contents);

        $tableComment = '';
        if ($this->hasTableComment() && $databaseBuilder->hasTableComment()) {
            $tableComment = $databaseBuilder->makeTableComment($this);
        }

        $contents = str_replace('{{ tableComment }}', $tableComment, $contents);

        $str = '';

        if ($this->getEngine()->hasValue()) {
            $str .= $this->getEngine()->makeMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        if ($this->getCharset()->hasValue()) {
            $str .= $this->getCharset()->makeMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        if ($this->getCollation()->hasValue()) {
            $str .= $this->getCollation()->makeMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        if ($this->getTemporary()->isEnable()) {
            $str .= $this->getTemporary()->makeMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        foreach ($this->getColumnList() as $column) {
            $str .= $column->createColumnMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        $contents = str_replace('{{ up }}', trim($str), $contents);

        return new MigrationFile($name, $contents);
    }

    /**
     * @param MigrationUpdateStub $migrationUpdateStub
     * @return MigrationFile|null
     */
    public function makeCreateIndexMigrationFile(MigrationUpdateStub $migrationUpdateStub): ?MigrationFile
    {
        if ($this->hasIndexModifierList() === false) {
            return null;
        }

        $name = sprintf('1970_01_01_000002_create_%s_index.php', $this->getTableName());
        $contents = $migrationUpdateStub->getStub();
        $contents = str_replace('{{ connection }}', $this->getConnection()->makeMigration(), $contents);
        $contents = str_replace('{{ table }}', $this->getTableName(), $contents);

        $up = '';

        $indexListIterator = $this->getIndexModifierList()->getIterator();

        while ($indexListIterator->valid()) {
            $up .= $indexListIterator->current()->createIndexMigrationUpMethod();
            $indexListIterator->next();

            if ($indexListIterator->valid()) {
                $up .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        $contents = str_replace('{{ up }}', $up, $contents);

        $down = '';

        $indexListIterator = $this->getIndexModifierList()->getIterator();

        while ($indexListIterator->valid()) {
            $down .= $indexListIterator->current()->createIndexMigrationDownMethod();
            $indexListIterator->next();

            if ($indexListIterator->valid()) {
                $down .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        $contents = str_replace('{{ down }}', $down, $contents);

        return new MigrationFile($name, $contents);
    }

    /**
     * @param MigrationUpdateStub $migrationUpdateStub
     * @return MigrationFile|null
     */
    public function makeConstraintForeignKeyMigrationFile(MigrationUpdateStub $migrationUpdateStub): ?MigrationFile
    {
        if ($this->hasForeignKeyList() === false) {
            return null;
        }

        $name = sprintf('1970_01_01_000003_constraint_%s_foreign_key.php', $this->getTableName());
        $contents = $migrationUpdateStub->getStub();
        $contents = str_replace('{{ connection }}', $this->getConnection()->makeMigration(), $contents);
        $contents = str_replace('{{ table }}', $this->getTableName(), $contents);

        $up = '';

        $foreignKeyListIterator = $this->getForeignKeyList()->getIterator();

        while ($foreignKeyListIterator->valid()) {
            $up .= $foreignKeyListIterator->current()->createForeignKeyMigrationUpMethod();
            $foreignKeyListIterator->next();

            if ($foreignKeyListIterator->valid()) {
                $up .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        $contents = str_replace('{{ up }}', $up, $contents);

        $down = '';

        $foreignKeyListIterator = $this->getForeignKeyList()->getIterator();

        while ($foreignKeyListIterator->valid()) {
            $down .= $foreignKeyListIterator->current()->createForeignKeyMigrationDownMethod();
            $foreignKeyListIterator->next();

            if ($foreignKeyListIterator->valid()) {
                $down .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        $contents = str_replace('{{ down }}', $down, $contents);

        return new MigrationFile($name, $contents);
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table->getTableName()->getName();
    }

    /**
     * @return string
     */
    public function getTableComment(): string
    {
        return $this->table->getTableComment()->get();
    }

    /**
     * @return bool
     */
    public function hasTableComment(): bool
    {
        return $this->table->getTableComment()->exists();
    }

    /**
     * @return bool
     */
    public function hasColumnList(): bool
    {
        return $this->columnList->exists();
    }

    /**
     * @return bool
     */
    public function hasIndexModifierList(): bool
    {
        return $this->sqlIndexList->exists();
    }

    /**
     * @return bool
     */
    public function hasForeignKeyList(): bool
    {
        return $this->foreignKeyList->exists();
    }

    /**
     * @return ColumnList
     */
    public function getColumnList(): ColumnList
    {
        return $this->columnList;
    }

    /**
     * @return IndexModifierList
     */
    public function getIndexModifierList(): IndexModifierList
    {
        return $this->sqlIndexList;
    }

    /**
     * @return ForeignKeyList
     */
    public function getForeignKeyList(): ForeignKeyList
    {
        return $this->foreignKeyList;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->table->getConnection();
    }

    /**
     * @return Engine
     */
    public function getEngine(): Engine
    {
        return $this->table->getEngine();
    }

    /**
     * @return Charset
     */
    public function getCharset(): Charset
    {
        return $this->table->getCharset();
    }

    /**
     * @return Collation
     */
    public function getCollation(): Collation
    {
        return $this->table->getCollation();
    }

    /**
     * @return Temporary
     */
    public function getTemporary(): Temporary
    {
        return $this->table->getTemporary();
    }

    /**
     * @return bool
     */
    public function isDbFacadeUsing(): bool
    {
        if ($this->table->getTableComment()->exists()) {
            return true;
        }

        foreach ($this->columnList as $column) {
            if ($column->isDbFacadeUsing()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    private function makeMigrationNamespace(): string
    {
        if ($this->isDbFacadeUsing()) {
            return <<< 'EOF'
            use Illuminate\Database\Migrations\Migration;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Support\Facades\DB;
            use Illuminate\Support\Facades\Schema;
            EOF;
        }

        return <<< 'EOF'
        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;
        EOF;
    }
}
