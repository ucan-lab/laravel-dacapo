<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\DomainService;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;

class SchemaToCreateTableClassConverter
{
    const MIGRATION_COLUMN_INDENT = '            ';

    protected Schema $schema;

    /**
     * SchemaToCreateTableClassConverter constructor.
     * @param Schema $schema
     */
    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return array
     */
    public function convert(): array
    {
        return [
            $this->makeMigrationFileName(),
            $this->makeMigrationContents(),
        ];
    }

    /**
     * @return string
     */
    protected function makeMigrationFileName(): string
    {
        return sprintf('1970_01_01_000000_%s.php', $this->makeMigrationName());
    }

    /**
     * @return string
     */
    protected function makeMigrationName(): string
    {
        return sprintf('create_%s_table', $this->schema->getTableName());
    }

    /**
     * @return string
     */
    protected function makeMigrationContents(): string
    {
        $stub = file_get_contents(__DIR__ . '/../../../Infra/Storage/stubs/migration.create.stub');
        $stub = str_replace('{{ class }}', $this->makeMigrationClassName(), $stub);
        $stub = str_replace('{{ table }}', $this->schema->getTableName(), $stub);
        $stub = str_replace('{{ columns }}', $this->makeMigrationColumns(), $stub);

        return $stub;
    }

    /**
     * @return string
     */
    protected function makeMigrationClassName(): string
    {
        return Str::studly($this->makeMigrationName());
    }

    /**
     * @return string
     */
    protected function makeMigrationColumns(): string
    {
        $str = '';

        $columnListIterator = $this->schema->getColumnList()->getIterator();

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
