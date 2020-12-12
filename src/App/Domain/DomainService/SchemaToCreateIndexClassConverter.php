<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\DomainService;

use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;

class SchemaToCreateIndexClassConverter
{
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
        return sprintf('1970_01_01_000000_create_%s_table.php', $this->schema->getTableName());
    }

    /**
     * @return string
     */
    protected function makeMigrationContents(): string
    {
        return 'makeMigrationContents';
    }
}
