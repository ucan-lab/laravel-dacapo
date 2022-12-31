<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\DacapoCommandUseCase;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseMigrationsStorage;

/**
 * Class DacapoCommand.
 */
final class DacapoCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo
        {--f|force : Force the operation to run when in production}
        {--no-migrate : Do not migrate}
        {--seed : Seed the database with records}
        {--refresh : Migrate refresh (for debug)}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate migrations from schemas and migrate:fresh command.';

    /**
     * @param DacapoCommandUseCase $useCase
     */
    public function handle(
        DacapoCommandUseCase $useCase,
    ): void {
        $this->call('dacapo:clear', ['--force' => true]);

        $this->newLine();
        $this->components->info( 'Generating migration files.');

        $output = $useCase->handle();

        foreach ($output->generatedFileNameList as $generatedFileName) {
            $this->components->task($generatedFileName);
        }

        if ($this->option('no-migrate')) {
            $this->line('No migrate.');

            return;
        }

        $this->call('migrate:fresh', ['--force' => true]);

        if ($this->option('refresh')) {
            $this->call('migrate:refresh', ['--force' => true]);
        }

        if ($this->option('seed')) {
            $this->call('db:seed', ['--force' => true]);
        }
    }
}
