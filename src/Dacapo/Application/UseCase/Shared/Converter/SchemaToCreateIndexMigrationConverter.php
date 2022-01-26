<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Converter;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Stub\MigrationUpdateStub;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;

final class SchemaToCreateIndexMigrationConverter
{
    private const MIGRATION_COLUMN_INDENT = '            ';
    private MigrationUpdateStub $migrationUpdateStub;

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
        $migrationFileList = [];

        foreach ($schemaList as $schema) {
            if ($schema->hasIndexModifierList()) {
                $migrationFileList[] = $this->convert($schema);
            }
        }

        return new MigrationFileList($migrationFileList);
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
        return sprintf('1970_01_01_000002_%s.php', $this->makeMigrationName($schema));
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationName(Schema $schema): string
    {
        return sprintf('create_%s_index', $schema->getTableName());
    }

    /**
     * @param Schema $schema
     * @return string
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

        $indexListIterator = $schema->getIndexModifierList()->getIterator();

        while ($indexListIterator->valid()) {
            $str .= $indexListIterator->current()->createIndexMigrationUpMethod();
            $indexListIterator->next();

            if ($indexListIterator->valid()) {
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

        $indexListIterator = $schema->getIndexModifierList()->getIterator();

        while ($indexListIterator->valid()) {
            $str .= $indexListIterator->current()->createIndexMigrationDownMethod($schema->getTableName());
            $indexListIterator->next();

            if ($indexListIterator->valid()) {
                $str .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        return $str;
    }
}
