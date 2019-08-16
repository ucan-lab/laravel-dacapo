<?php

namespace UcanLab\LaravelDacapo\Providers;

use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Console\DacapoClearCommand;
use UcanLab\LaravelDacapo\Console\DacapoGenerateCommand;
use UcanLab\LaravelDacapo\Console\DacapoInitCommand;
use UcanLab\LaravelDacapo\Console\DacapoUninstallCommand;

/**
 * Class ConsoleServiceProvider
 */
class ConsoleServiceProvider extends ServiceProvider
{
    /** @var bool */
    protected $defer = true;

    public function boot()
    {
        $this->bootPublishes();
        $this->registerCommands();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // register bindings
    }

    /**
     * Bootstrap publishes
     *
     * @return void
     */
    protected function bootPublishes()
    {
        $schemaPath = __DIR__ . '/../Storage';

        $this->publishes([
            $schemaPath . '/schema.yml' => database_path('schema.yml'),
        ]);
    }

    /**
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->singleton('command.ucan.dacapo.init', function () {
            return new DacapoInitCommand();
        });

        $this->app->singleton('command.ucan.dacapo.generate', function () {
            return new DacapoGenerateCommand();
        });

        $this->app->singleton('command.ucan.dacapo.clear', function () {
            return new DacapoClearCommand();
        });

        $this->app->singleton('command.ucan.dacapo.uninstall', function () {
            return new DacapoUninstallCommand();
        });

        $this->commands([
            'command.ucan.dacapo.init',
            'command.ucan.dacapo.generate',
            'command.ucan.dacapo.clear',
            'command.ucan.dacapo.uninstall',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            'command.ucan.dacapo.init',
            'command.ucan.dacapo.generate',
            'command.ucan.dacapo.clear',
            'command.ucan.dacapo.uninstall',
        ];
    }
}
