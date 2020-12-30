<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\App\UseCase\SchemaConverter\CreateForeignKeyMigrationConverter;
use UcanLab\LaravelDacapo\App\UseCase\SchemaConverter\CreateIndexMigrationConverter;
use UcanLab\LaravelDacapo\App\UseCase\SchemaConverter\CreateTableMigrationConverter;

class DacapoCommandUseCase
{
    protected SchemaListRepository $schemaListRepository;
    protected MigrationListRepository $migrationListRepository;
    protected CreateTableMigrationConverter $createTableMigrationConverter;
    protected CreateIndexMigrationConverter $createIndexMigrationConverter;
    protected CreateForeignKeyMigrationConverter $createForeignKeyMigrationConverter;

    /**
     * DacapoCommandUseCase constructor.
     * @param SchemaListRepository $schemaListRepository
     * @param MigrationListRepository $migrationListRepository
     * @param CreateTableMigrationConverter $createTableMigrationConverter
     * @param CreateIndexMigrationConverter $createIndexMigrationConverter
     * @param CreateForeignKeyMigrationConverter $createForeignKeyMigrationConverter
     */
    public function __construct (
        SchemaListRepository $schemaListRepository,
        MigrationListRepository $migrationListRepository,
        CreateTableMigrationConverter $createTableMigrationConverter,
        CreateIndexMigrationConverter $createIndexMigrationConverter,
        CreateForeignKeyMigrationConverter $createForeignKeyMigrationConverter
    ) {
        $this->schemaListRepository = $schemaListRepository;
        $this->migrationListRepository = $migrationListRepository;
        $this->createTableMigrationConverter = $createTableMigrationConverter;
        $this->createIndexMigrationConverter = $createIndexMigrationConverter;
        $this->createForeignKeyMigrationConverter = $createForeignKeyMigrationConverter;
    }

    /**
     * @throws
     */
    public function handle(): void
    {
        foreach ($this->schemaListRepository->get() as $schema) {
            if ($schema->hasColumnList()) {
                [$name, $contents] = $this->createTableMigrationConverter->convert($schema);
                $this->migrationListRepository->saveFile($name, $contents);
            }

            if ($schema->hasSqlIndexList()) {
                [$name, $contents] = $this->createIndexMigrationConverter->convert($schema);
                $this->migrationListRepository->saveFile($name, $contents);
            }

            if ($schema->hasForeignKeyList()) {
                [$name, $contents] = $this->createForeignKeyMigrationConverter->convert($schema);
                $this->migrationListRepository->saveFile($name, $contents);
            }
        }
    }
}
