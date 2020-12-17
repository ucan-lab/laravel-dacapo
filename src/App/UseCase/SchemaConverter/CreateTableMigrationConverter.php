<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\SchemaConverter;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;

class CreateTableMigrationConverter
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
        return sprintf('1970_01_01_000000_%s.php', $this->makeMigrationName($schema));
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
        $stub = file_get_contents(__DIR__ . '/../../../Infra/Storage/stubs/migration.create.stub');
        $stub = str_replace('{{ class }}', $this->makeMigrationClassName($schema), $stub);
        $stub = str_replace('{{ table }}', $schema->getTableName(), $stub);
        $stub = str_replace('{{ up }}', $this->makeMigrationUp($schema), $stub);

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

        $columnListIterator = $schema->getColumnList()->getIterator();

        while ($columnListIterator->valid()) {
            $str .= $columnListIterator->current()->createColumnMigration();
            $columnListIterator->next();

            if ($columnListIterator->valid()) {
                $str .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        return $str;
    }
}
