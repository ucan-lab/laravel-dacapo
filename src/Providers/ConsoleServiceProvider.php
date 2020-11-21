<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Providers;

use Illuminate\Support\ServiceProvider;
use UcanLab\LaravelDacapo\Console\DacapoClearCommand;

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
            return new DacapoClearCommand();
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
        ];
    }
}
