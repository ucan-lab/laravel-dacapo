<?php

namespace UcanLab\LaravelDacapo;

use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Console\DacapoGenerateCommand;
use UcanLab\LaravelDacapo\Console\DacapoClearCommand;

/**
 * Class ConsoleServiceProvider
 */
class ConsoleServiceProvider extends ServiceProvider
{
    /** @var bool */
    protected $defer = true;

    public function boot()
    {
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
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->singleton('command.ucan.dacapo.generate', function () {
            return new DacapoGenerateCommand();
        });

        $this->app->singleton('command.ucan.dacapo.clear', function () {
            return new DacapoClearCommand();
        });

        $this->commands([
            'command.ucan.dacapo.generate',
            'command.ucan.dacapo.clear',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            'command.ucan.dacapo.generate',
            'command.ucan.dacapo.clear',
        ];
    }
}
