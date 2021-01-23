<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Converter;

use DateTime;
use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\Schema;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;

class SchemaToConstraintForeignKeyMigrationConverter
{
    const MIGRATION_COLUMN_INDENT = '            ';
    protected DateTime $prefixDate;

    /**
     * SchemaToConstraintForeignKeyMigrationConverter constructor.
     * @param DateTime $prefixDate
     */
    public function __construct(DateTime $prefixDate)
    {
        $this->prefixDate = $prefixDate;
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
     * @param DateTime $prefixDate
     * @return $this
     */
    public function setPrefixDate(DateTime $prefixDate): self
    {
        $this->prefixDate = $prefixDate;

        return $this;
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
        return sprintf('%s_000003_%s.php', $this->prefixDate->format('Y_m_d'), $this->makeMigrationName($schema));
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
        $stub = file_get_contents(__DIR__ . '/../../App/Storage/stubs/migration.update.stub');
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
