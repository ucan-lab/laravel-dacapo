<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\App\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Console\DacapoClearCommand;
use UcanLab\LaravelDacapo\Console\DacapoCommand;
use UcanLab\LaravelDacapo\Console\DacapoInitCommand;
use UcanLab\LaravelDacapo\Console\DacapoUninstallCommand;
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
