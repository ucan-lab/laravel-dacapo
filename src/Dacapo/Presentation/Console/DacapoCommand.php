<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Exception;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Yaml\Yaml;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\DacapoCommandUseCase;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input\DacapoCommandUseCaseInput;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseMigrationsStorage;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

/**
 * Class DacapoCommand.
 */
class DacapoCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo
        {--f|force : Force the operation to run when in production}
        {--no-migrate : Do not migrate}
        {--seed : Seed the database with records}
        {--refresh : Migrate refresh (for debug)}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate migrations from schemas and migrate:fresh command.';

    /**
     * @param DacapoCommandUseCase $useCase
     * @param DatabaseSchemasStorage $databaseSchemasStorage
     * @param DatabaseMigrationsStorage $databaseMigrationsStorage
     * @throws Exception
     */
    public function handle(
        DacapoCommandUseCase $useCase,
        DatabaseSchemasStorage $databaseSchemasStorage,
        DatabaseMigrationsStorage $databaseMigrationsStorage
    ): void {
        $this->call('dacapo:clear', ['--force' => true]);

        $input = $this->makeDacapoCommandUseCaseInput($databaseSchemasStorage->getFilePathList());
        $output = $useCase->handle($input);

        foreach ($output->migrationFileList as $migrationFile) {
            $databaseMigrationsStorage->saveFile($migrationFile->getName(), $migrationFile->getContents());
            $this->line(sprintf('<fg=green>Generated:</> %s', $migrationFile->getName()));
        }

        if ($this->option('no-migrate')) {
            $this->line('No migrate.');

            return;
        }

        $this->call('migrate:fresh', ['--force' => true]);

        if ($this->option('refresh')) {
            $this->call('migrate:refresh', ['--force' => true]);
        }

        if ($this->option('seed')) {
            $this->call('db:seed', ['--force' => true]);
        }
    }

    /**
     * @param array $ymlFiles
     * @return DacapoCommandUseCaseInput
     * @throws Exception
     */
    private function makeDacapoCommandUseCaseInput(array $ymlFiles): DacapoCommandUseCaseInput
    {
        $schemaFiles = [];

        foreach ($ymlFiles as $ymlFile) {
            $parsedYmlFile = Yaml::parseFile($ymlFile);

            $intersectKeys = array_intersect_key($schemaFiles, $parsedYmlFile);

            if (count($intersectKeys) > 0) {
                throw new Exception(sprintf('Duplicate table name for `%s` in the schema YAML', implode(', ', array_keys($intersectKeys))));
            }

            $schemaFiles = array_merge($schemaFiles, $parsedYmlFile);
        }

        return new DacapoCommandUseCaseInput($schemaFiles);
    }
}