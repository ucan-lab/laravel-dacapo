<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\App\Port\MigrationsStorage;
use UcanLab\LaravelDacapo\App\Port\SchemasStorage;
use UcanLab\LaravelDacapo\Console\DacapoClearCommand;
use UcanLab\LaravelDacapo\Console\DacapoUninstallCommand;
use UcanLab\LaravelDacapo\Infra\Adapter\LocalMigrationsStorage;
use UcanLab\LaravelDacapo\Infra\Adapter\LocalSchemasStorage;

/**
 * Class ConsoleServiceProvider.
 */
class ConsoleServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $bindings = [
        MigrationsStorage::class => LocalMigrationsStorage::class,
        SchemasStorage::class => LocalSchemasStorage::class,
    ];

    protected array $commands = [
        DacapoClearCommand::class,
        DacapoUninstallCommand::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->registerBindings();
        $this->registerCommands();
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return $this->commands;
    }

    protected function registerBindings(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    protected function registerCommands(): void
    {
        $this->commands($this->commands);
    }
}
