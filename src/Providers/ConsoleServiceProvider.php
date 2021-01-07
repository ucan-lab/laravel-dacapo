<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Providers;

use Exception;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Console\DacapoClearCommand;
use UcanLab\LaravelDacapo\Console\DacapoCommand;
use UcanLab\LaravelDacapo\Console\DacapoInitCommand;
use UcanLab\LaravelDacapo\Console\DacapoUninstallCommand;
use UcanLab\LaravelDacapo\Dacapo\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\Dacapo\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\DatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\MysqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\PostgresqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Infra\Adapter\LocalMigrationListRepository;
use UcanLab\LaravelDacapo\Infra\Adapter\LocalSchemaListRepository;

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

        $driver = $this->getDatabaseDriver();

        if (isset($this->databaseBuilders[$driver]) === false) {
            throw new Exception(sprintf('driver %s is not found.', $driver));
        }

        $this->app->bind(DatabaseBuilder::class, $this->databaseBuilders[$driver]);
    }

    /**
     * @return string
     */
    protected function getDatabaseDriver(): string
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        return (string) $driver;
    }
}
