<?php

namespace UcanLab\LaravelDacapo;

use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Console\SchemaGenerate;

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
        $this->app->singleton('command.ucan.dacapo.schema.generate', function () {
            return new SchemaGenerate();
        });

        $this->commands([
            'command.ucan.dacapo.schema.generate',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            'command.ucan.dacapo.schema.generate',
        ];
    }
}
