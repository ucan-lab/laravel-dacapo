<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Converter;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Stub\MigrationUpdateStub;
use UcanLab\LaravelDacapo\Dacapo\Domain\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;

class SchemaToConstraintForeignKeyMigrationConverter
{
    const MIGRATION_COLUMN_INDENT = '            ';
    protected MigrationUpdateStub $migrationUpdateStub;

    /**
     * @param MigrationUpdateStub $migrationUpdateStub
     */
    public function __construct(MigrationUpdateStub $migrationUpdateStub)
    {
        $this->migrationUpdateStub = $migrationUpdateStub;
    }

    /**
     * @param SchemaList $schemaList
     * @return MigrationFileList
     */
    public function convertList(SchemaList $schemaList): MigrationFileList
    {
        $fileList = new MigrationFileList();

        foreach ($schemaList as $schema) {
            if ($schema->hasForeignKeyList()) {
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
        return sprintf('1970_01_01_000003_%s.php', $this->makeMigrationName($schema));
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationName(Schema $schema): string
    {
        return sprintf('constraint_%s_foreign_key', $schema->getTableName());
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
     * @return string
     * @param Schema $schema
     */
    protected function makeMigrationContents(Schema $schema): string
    {
        $stub = $this->migrationUpdateStub->getStub();
        $stub = str_replace('{{ class }}', $this->makeMigrationClassName($schema), $stub);
        $stub = str_replace('{{ connection }}', $this->makeMigrationConnection($schema), $stub);
        $stub = str_replace('{{ table }}', $schema->getTableName(), $stub);
        $stub = str_replace('{{ up }}', $this->makeMigrationUp($schema), $stub);
        $stub = str_replace('{{ down }}', $this->makeMigrationDown($schema), $stub);

        return $stub;
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationUp(Schema $schema): string
    {
        $str = '';

        $foreignKeyListIterator = $schema->getForeignKeyList()->getIterator();

        while ($foreignKeyListIterator->valid()) {
            $str .= $foreignKeyListIterator->current()->createForeignKeyMigrationUpMethod();
            $foreignKeyListIterator->next();

            if ($foreignKeyListIterator->valid()) {
                $str .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        return $str;
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationDown(Schema $schema): string
    {
        $str = '';

        $foreignKeyListIterator = $schema->getForeignKeyList()->getIterator();

        while ($foreignKeyListIterator->valid()) {
            $str .= $foreignKeyListIterator->current()->createForeignKeyMigrationDownMethod();
            $foreignKeyListIterator->next();

            if ($foreignKeyListIterator->valid()) {
                $str .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        return $str;
    }
}
