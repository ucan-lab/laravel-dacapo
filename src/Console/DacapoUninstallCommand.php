<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
     * @return void
     */
    public function handle()
    {
        $this->uninstallDacapo();
    }

    /**
     * Uninstall dacapo
     *
     * @return void
     */
    private function uninstallDacapo(): void
    {
        $this->deleteSchemasDirectory();
        $this->info('Deleted schemas directory.');
        $this->info('Please delete dacapo composer package.');
        $this->comment('composer remove --dev ucan-lab/laravel-dacapo');
    }

    /**
     * @return bool
     */
    private function deleteSchemasDirectory(): bool
    {
        return File::deleteDirectory($this->getSchemasPath());
    }

    /**
     * @return string
     */
    private function getSchemasPath(): string
    {
        return database_path('schemas');
    }
}
