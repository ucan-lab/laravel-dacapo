<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Class DacapoClear
 */
class DacapoClear extends Command
{
    /** @var string */
    protected $name = 'dacapo:clear';

    /** @var string */
    protected $description = 'Clear migration directory.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle()
    {
        $this->clearMigrationDirectory();
    }

    /**
     * clear migrations directory
     *
     * @return void
     */
    private function clearMigrationDirectory()
    {
        File::deleteDirectory(database_path('migrations'));
        File::makeDirectory(database_path('migrations'));
        $this->info('Cleard Migration Directory');
    }
}
