<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\Storage\MigrationsStorage;

/**
 * Class DacapoClearCommand.
 */
class DacapoClearCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:clear {--f|force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear migration directory.';

    /**
     * Create a new console command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->clearMigrationDirectory();
    }

    /**
     * clear migrations directory.
     *
     * @return void
     */
    private function clearMigrationDirectory(): void
    {
        $storage = new MigrationsStorage();
        $storage->deleteDirectory();
        $storage->makeDirectory();
        $this->info('Cleared migration directory.');
    }
}
