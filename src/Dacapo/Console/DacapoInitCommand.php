<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Console;

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
        {--no-migrate : Do not migrate}
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

        $version = 'laravel9';

        $from = __DIR__ . '/DacapoInitCommand/' . $version . '.yml';
        $to = $this->laravel->databasePath('schemas/default.yml');
        file_put_contents($to, file_get_contents($from));
        $this->newLine();
        $this->components->info('Generated database/schemas/default.yml');

        $this->call('dacapo:clear', ['--all' => true]);
        $this->call('dacapo', ['--no-migrate' => $this->option('no-migrate')]);
    }
}
