<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Filesystem\Filesystem;

/**
 * Class DacapoInitCommand
 */
final class DacapoInitCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:init
        {--no-clear : Do not execute the dacapo:clear command}
        {--laravel6 : Laravel 6.x default schema}
        {--laravel7 : Laravel 7.x default schema}
        {--laravel8 : Laravel 8.x default schema}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init dacapo default schema.';

    /**
     * @param Filesystem $filesystem
     */
    public function handle(Filesystem $filesystem): void
    {
        if (! is_dir($schemasPath = $this->laravel->databasePath('schemas'))) {
            $filesystem->makeDirectory($schemasPath);
        }

        if ($this->option('no-clear') === false) {
            $this->call('dacapo:clear', ['--force' => true, '--all' => true]);
        }

        $version = 'laravel8';

        if ($this->option('laravel8')) {
            $version = 'laravel8';
        } elseif ($this->option('laravel7')) {
            $version = 'laravel7';
        } elseif ($this->option('laravel6')) {
            $version = 'laravel6';
        }

        $from = __DIR__ . '/DacapoInitCommand/' . $version . '.yml';
        $to = $this->laravel->databasePath('schemas/default.yml');
        file_put_contents($to, file_get_contents($from));

        $this->line('<fg=green>Generated:</> database/schemas/default.yml');
    }
}
