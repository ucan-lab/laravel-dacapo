<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Filesystem\Filesystem;

/**
 * Class DacapoClearCommand.
 */
final class DacapoClearCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:clear
        {--a|all : Delete all migration files}
        {--f|force : Force the operation to run when in production}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear migration directory.';

    /**
     * @param Filesystem $filesystem
     */
    public function handle(Filesystem $filesystem): void
    {
        $this->newLine();
        $this->components->info('Deleting migration files.');

        $migrationsPath = $this->laravel->databasePath('migrations');
        $files = array_map(fn ($f) => (string) $f->getRealPath(), $filesystem->files($migrationsPath));

        if ($this->option('all') === false) {
            $files = array_filter($files, fn ($f) => str_contains($f, '1970_01_01'));
        }

        foreach ($files as $file) {
            $filesystem->delete($file);
            $this->components->task(pathinfo($file, PATHINFO_BASENAME));
        }
    }
}
