<?php

namespace UcanLab\LaravelDacapo;

use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Console\DacapoGenerate;
use UcanLab\LaravelDacapo\Console\DacapoClear;

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
            return new DacapoGenerate();
        });

        $this->app->singleton('command.ucan.dacapo.clear', function () {
            return new DacapoClear();
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
