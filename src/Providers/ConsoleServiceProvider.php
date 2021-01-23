<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Providers;

use Exception;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Console\DacapoClearCommand;
use UcanLab\LaravelDacapo\Console\DacapoCommand;
use UcanLab\LaravelDacapo\Console\DacapoInitCommand;
use UcanLab\LaravelDacapo\Console\DacapoUninstallCommand;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\LocalMigrationListRepository;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\LocalSchemaListRepository;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\DatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\MysqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\PostgresqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\SqliteDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\SqlsrvDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\SchemaListRepository;

/**
 * Class ConsoleServiceProvider.
 */
class ConsoleServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $bindings = [
        SchemaListRepository::class => LocalSchemaListRepository::class,
        MigrationListRepository::class => LocalMigrationListRepository::class,
    ];

    protected array $commands = [
        DacapoInitCommand::class,
        DacapoCommand::class,
        DacapoClearCommand::class,
        DacapoUninstallCommand::class,
    ];

    protected array $databaseBuilders = [
        'mysql' => MysqlDatabaseBuilder::class,
        'pgsql' => PostgresqlDatabaseBuilder::class,
        'sqlsrv' => SqlsrvDatabaseBuilder::class,
        'sqlite' => SqliteDatabaseBuilder::class,
    ];

    /**
     * {@inheritdoc}
     * @throws
     */
    public function register(): void
    {
        $this->registerCommands();
        $this->registerBindings();
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return $this->commands;
    }

    protected function registerCommands(): void
    {
        $this->commands($this->commands);
    }

    /**
     * @throws Exception
     */
    protected function registerBindings(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        $this->app->bind(DatabaseBuilder::class, $this->concreteDatabaseBuilder());
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function concreteDatabaseBuilder(): string
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if (isset($this->databaseBuilders[$driver]) === false) {
            throw new Exception(sprintf('driver %s is not found.', $driver));
        }

        return $this->databaseBuilders[$driver];
    }
}
