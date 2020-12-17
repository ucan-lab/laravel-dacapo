<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\DomainService;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;

class SchemaToCreateIndexClassConverter
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
        return sprintf('1970_01_01_000001_%s.php', $this->makeMigrationName());
    }

    /**
     * @return string
     */
    protected function makeMigrationName(): string
    {
        return sprintf('create_%s_index', $this->schema->getTableName());
    }

    /**
     * @return string
     */
    protected function makeMigrationContents(): string
    {
        $stub = file_get_contents(__DIR__ . '/../../../Infra/Storage/stubs/migration.update.stub');
        $stub = str_replace('{{ class }}', $this->makeMigrationClassName(), $stub);
        $stub = str_replace('{{ table }}', $this->schema->getTableName(), $stub);
        $stub = str_replace('{{ up }}', $this->makeMigrationUp(), $stub);
        $stub = str_replace('{{ down }}', $this->makeMigrationDown(), $stub);

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
    protected function makeMigrationUp(): string
    {
        $str = '';

        $indexListIterator = $this->schema->getIndexList()->getIterator();

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
     * @return string
     */
    protected function makeMigrationDown(): string
    {
        $str = '';

        $indexListIterator = $this->schema->getIndexList()->getIterator();

        while ($indexListIterator->valid()) {
            $str .= $indexListIterator->current()->createIndexMigrationDownMethod($this->schema->getTableName());
            $indexListIterator->next();

            if ($indexListIterator->valid()) {
                $str .= PHP_EOL . self::MIGRATION_COLUMN_INDENT;
            }
        }

        return $str;
    }
}
