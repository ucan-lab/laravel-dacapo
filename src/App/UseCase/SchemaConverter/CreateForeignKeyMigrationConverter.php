<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\SchemaConverter;

use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;

class CreateForeignKeyMigrationConverter
{
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
        return sprintf('1970_01_01_000002_constraint_%s_relation.php', $schema->getTableName());
    }

    /**
     * @return string
     */
    protected function makeMigrationContents(Schema $schema): string
    {
        return 'makeMigrationContents';
    }
}
