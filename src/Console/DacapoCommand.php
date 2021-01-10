<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Console\DacapoCommandUseCase;

/**
 * Class DacapoCommand.
 */
class DacapoCommand extends Command
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
     * @var DacapoCommandUseCase
     */
    protected DacapoCommandUseCase $useCase;

    /**
     * DacapoCommand constructor.
     * @param DacapoCommandUseCase $useCase
     */
    public function __construct(DacapoCommandUseCase $useCase)
    {
        parent::__construct();

        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        $this->call('dacapo:clear', ['--force' => true]);

        $fileList = $this->useCase->handle();

        foreach ($fileList as $file) {
            $this->line(sprintf('<fg=green>Generated:</> %s', $file->getName()));
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
