<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Converter;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;

class SchemaToCreateIndexMigrationConverter
{
    const MIGRATION_COLUMN_INDENT = '            ';
    protected Schema $schema;

    /**
     * @param Schema $schema
     * @return array
     */
    public function convert(Schema $schema): array
    {
        return [
            $this->makeMigrationFileName($schema),
            $this->makeMigrationContents($schema),
        ];
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
        return sprintf('create_%s_index', $schema->getTableName());
    }

    /**
     * @param Schema $schema
     * @return string
     */
    protected function makeMigrationContents(Schema $schema): string
    {
        $stub = file_get_contents(__DIR__ . '/../../../Infra/Storage/stubs/migration.update.stub');
        $stub = str_replace('{{ class }}', $this->makeMigrationClassName($schema), $stub);
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
    protected function makeMigrationUp(Schema $schema): string
    {
        $str = '';

        $indexListIterator = $schema->getSqlIndexList()->getIterator();

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

        $indexListIterator = $schema->getSqlIndexList()->getIterator();

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
