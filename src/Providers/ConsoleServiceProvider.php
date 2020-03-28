<?php

namespace UcanLab\LaravelDacapo\Providers;

use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Console\DacapoCommand;
use UcanLab\LaravelDacapo\Console\DacapoInitCommand;
use UcanLab\LaravelDacapo\Console\DacapoSeedCommand;
use UcanLab\LaravelDacapo\Console\DacapoClearCommand;
use UcanLab\LaravelDacapo\Console\DacapoFreshCommand;
use UcanLab\LaravelDacapo\Console\DacapoModelsCommand;
use UcanLab\LaravelDacapo\Console\DacapoUninstallCommand;

/**
 * Class ConsoleServiceProvider.
 */
class ConsoleServiceProvider extends ServiceProvider
{
    /** @var bool */
    protected $defer = true;

    public function boot(): void
    {
        $this->registerCommands();
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        // register bindings
    }

    /**
     * @return void
     */
    protected function registerCommands(): void
    {
        $this->app->singleton('command.ucan.dacapo.init', function () {
            return new DacapoInitCommand();
        });

        $this->app->singleton('command.ucan.dacapo', function () {
            return new DacapoCommand();
        });

        $this->app->singleton('command.ucan.dacapo.fresh', function () {
            return new DacapoFreshCommand();
        });

        $this->app->singleton('command.ucan.dacapo.seed', function () {
            return new DacapoSeedCommand();
        });

        $this->app->singleton('command.ucan.dacapo.models', function () {
            return new DacapoModelsCommand();
        });

        $this->app->singleton('command.ucan.dacapo.clear', function () {
            return new DacapoClearCommand();
        });

        $this->app->singleton('command.ucan.dacapo.uninstall', function () {
            return new DacapoUninstallCommand();
        });

        $this->commands($this->provides());
    }

    /**
     * {@inheritdoc}
     */
    public function provides(): array
    {
        return [
            'command.ucan.dacapo.init',
            'command.ucan.dacapo',
            'command.ucan.dacapo.fresh',
            'command.ucan.dacapo.seed',
            'command.ucan.dacapo.models',
            'command.ucan.dacapo.clear',
            'command.ucan.dacapo.uninstall',
        ];
    }
}
