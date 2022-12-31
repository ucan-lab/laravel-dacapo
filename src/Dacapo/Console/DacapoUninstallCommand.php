<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Filesystem\Filesystem;

/**
 * Class DacapoUninstallCommand
 */
final class DacapoUninstallCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall dacapo.';

    public function handle(Filesystem $filesystem): void
    {
        $this->newLine();
        $this->components->info('Uninstalling dacapo');
        if (is_dir($schemasPath = $this->laravel->databasePath('schemas'))) {
            $filesystem->deleteDirectory($schemasPath);
        }

        $this->components->info('Deleted schemas directory.');
        $this->components->info('Please dacapo composer remove package.');
        $this->comment('composer remove --dev ucan-lab/laravel-dacapo');
    }
}
