<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Console\ConfirmableTrait;

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
    protected function clearMigrationDirectory(): void
    {
        foreach ($this->getMigrationsFiles() as $filePath) {
            unlink($filePath);
        }

        $this->info('Cleared migration directory.');
    }

    /**
     * @return array
     */
    protected function getMigrationsFiles(): array
    {
        $files = [];

        foreach (File::allFiles(database_path('migrations')) as $file) {
            if ($file->getExtension() === 'php') {
                $files[] = $file->getRealPath();
            }
        }

        return $files;
    }
}
