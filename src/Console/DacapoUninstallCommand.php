<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;

/**
 * Class DacapoUninstallCommand.
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

    private $schemasStorage;

    public function __construct()
    {
        parent::__construct();
        $this->schemasStorage = new SchemasStorage();
    }

    /**
     * @return void
     */
    public function handle()
    {
        $this->uninstallDacapo();
    }

    /**
     * Uninstall dacapo.
     *
     * @return void
     */
    private function uninstallDacapo(): void
    {
        $this->schemasStorage->deleteDirectory();
        $this->info('Deleted schemas directory.');
        $this->info('Please delete dacapo composer package.');
        $this->comment('composer remove --dev ucan-lab/laravel-dacapo');
    }
}
