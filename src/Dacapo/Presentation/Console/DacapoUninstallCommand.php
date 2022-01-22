<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Illuminate\Filesystem\Filesystem;

/**
 * Class DacapoUninstallCommand
 */
class DacapoUninstallCommand extends Command
{
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

    /**
     * @param Filesystem $filesystem
     */
    public function handle(Filesystem $filesystem): void
    {
        if (is_dir($schemasPath = $this->laravel->databasePath('schemas'))) {
            $filesystem->deleteDirectory($schemasPath);
        }

        $this->info('Deleted schemas directory.');
        $this->info('Please delete dacapo composer package.');
        $this->comment('composer remove --dev ucan-lab/laravel-dacapo');
    }
}