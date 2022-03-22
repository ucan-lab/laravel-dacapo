<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Providers;

use Exception;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver\DatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Stub\MigrationCreateStub;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Stub\MigrationUpdateStub;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver\MysqlDatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver\PostgresqlDatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver\SqliteDatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver\SqlsrvDatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\LaravelDatabaseMigrationsStorage;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\LaravelDatabaseSchemasStorage;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Stub\LaravelMigrationCreateStub;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Stub\LaravelMigrationUpdateStub;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Console\DacapoClearCommand;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Console\DacapoCommand;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Console\DacapoInitCommand;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Console\DacapoMakeModelsCommand;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Console\DacapoStubPublishCommand;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Console\DacapoUninstallCommand;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseMigrationsStorage;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

/**
 * Class ConsoleServiceProvider.
 */
final class ConsoleServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @var array<string, string>
     */
    public array $bindings = [
        MigrationCreateStub::class => LaravelMigrationCreateStub::class,
        MigrationUpdateStub::class => LaravelMigrationUpdateStub::class,
        DatabaseMigrationsStorage::class => LaravelDatabaseMigrationsStorage::class,
    ];

    /**
     * @var array<int, string>
     */
    private array $commands = [
        DacapoInitCommand::class,
        DacapoCommand::class,
        DacapoMakeModelsCommand::class,
        DacapoClearCommand::class,
        DacapoStubPublishCommand::class,
        DacapoUninstallCommand::class,
    ];

    /**
     * @var array<string, string>
     */
    private array $databaseDrivers = [
        'mysql' => MysqlDatabaseDriver::class,
        'pgsql' => PostgresqlDatabaseDriver::class,
        'sqlsrv' => SqlsrvDatabaseDriver::class,
        'sqlite' => SqliteDatabaseDriver::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->registerCommands();
        $this->registerBindings();
    }

    /**
     * @return array<int, string>
     */
    public function provides()
    {
        return $this->commands;
    }

    private function registerCommands(): void
    {
        $this->commands($this->commands);
    }

    /**
     * @throws Exception
     */
    private function registerBindings(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        $this->app->bind(DatabaseDriver::class, $this->concreteDatabaseDriver());
        $this->app->bind(DatabaseSchemasStorage::class, function ($app) {
            return new LaravelDatabaseSchemasStorage($app->make(Filesystem::class), $app->databasePath('schemas'));
        });
    }

    /**
     * @return string
     * @throws Exception
     */
    private function concreteDatabaseDriver(): string
    {
        /** @var Connection $connection */
        $connection = $this->app->make(ConnectionInterface::class);
        $driver = $connection->getDriverName();

        $this->databaseDrivers[$driver] ?? throw new Exception(sprintf('driver %s is not found.', $driver));

        return $this->databaseDrivers[$driver];
    }
}
