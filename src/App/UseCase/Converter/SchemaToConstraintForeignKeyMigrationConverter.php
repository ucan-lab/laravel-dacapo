<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Converter;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration\MigrationFile;

class SchemaToConstraintForeignKeyMigrationConverter
{
    const MIGRATION_COLUMN_INDENT = '            ';
    protected Schema $schema;

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
        $stub = file_get_contents(__DIR__ . '/../../../Infra/Storage/stubs/migration.update.stub');
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
