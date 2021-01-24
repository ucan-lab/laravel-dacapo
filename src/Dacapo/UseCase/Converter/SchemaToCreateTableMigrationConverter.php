<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Converter;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\Schema;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\DatabaseBuilder;

class SchemaToCreateTableMigrationConverter
{
    const MIGRATION_COLUMN_INDENT = '            ';

    protected DatabaseBuilder $databaseBuilder;

    public function __construct(DatabaseBuilder $databaseBuilder)
    {
        $this->databaseBuilder = $databaseBuilder;
    }

    /**
     * @param SchemaList $schemaList
     * @return MigrationFileList
     */
    public function convertList(SchemaList $schemaList): MigrationFileList
    {
        $fileList = new MigrationFileList();

        foreach ($schemaList as $schema) {
            if ($schema->hasColumnList()) {
                $fileList->add($this->convert($schema));
            }
        }

        return $fileList;
    }

    /**
     * @param Schema $schema
     * @return MigrationFile
     */
    public function convert(Schema $schema): MigrationFile
    {
        return new MigrationFile($this->makeMigrationFileName($schema), $this->makeMigrationContents($schema));
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationFileName(Schema $schema): string
    {
        return sprintf('1970_01_01_000001_%s.php', $this->makeMigrationName($schema));
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationName(Schema $schema): string
    {
        return sprintf('create_%s_table', $schema->getTableName());
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationContents(Schema $schema): string
    {
        $stub = file_get_contents(__DIR__ . '/../../App/Storage/stubs/migration.create.stub');
        $stub = str_replace('{{ namespace }}', $this->makeMigrationNamespace($schema), $stub);
        $stub = str_replace('{{ class }}', $this->makeMigrationClassName($schema), $stub);
        $stub = str_replace('{{ connection }}', $this->makeMigrationConnection($schema), $stub);
        $stub = str_replace('{{ tableName }}', $schema->getTableName(), $stub);
        $stub = str_replace('{{ tableComment }}', $this->makeMigrationTableComment($schema), $stub);
        $stub = str_replace('{{ up }}', $this->makeMigrationUp($schema), $stub);

        return $stub;
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationNamespace(Schema $schema): string
    {
        if ($schema->useDbFacade()) {
            $str = <<< 'EOF'
            use Illuminate\Database\Migrations\Migration;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Support\Facades\DB;
            use Illuminate\Support\Facades\Schema;
            EOF;
        } else {
            $str = <<< 'EOF'
            use Illuminate\Database\Migrations\Migration;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Support\Facades\Schema;
            EOF;
        }

        return $str;
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationTableComment(Schema $schema): string
    {
        if ($schema->hasTableComment() && $this->databaseBuilder->hasTableComment()) {
            return $this->databaseBuilder->makeTableComment($schema);
        }

        return '';
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationClassName(Schema $schema): string
    {
        return Str::studly($this->makeMigrationName($schema));
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationConnection(Schema $schema): string
    {
        return $schema->getConnection()->makeMigration();
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationUp(Schema $schema): string
    {
        $str = '';

        if ($schema->getEngine()->hasValue()) {
            $str .= $schema->getEngine()->makeMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        if ($schema->getCharset()->hasValue()) {
            $str .= $schema->getCharset()->makeMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        if ($schema->getCollation()->hasValue()) {
            $str .= $schema->getCollation()->makeMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        if ($schema->getTemporary()->isEnable()) {
            $str .= $schema->getTemporary()->makeMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        foreach ($schema->getColumnList() as $column) {
            $str .= $column->createColumnMigration() . PHP_EOL . self::MIGRATION_COLUMN_INDENT;
        }

        return trim($str);
    }
}
