<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\App\UseCase\Console\DacapoCommandUseCase;

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
        $this->useCase->handle();
        $this->info('Generated migration files.');

        if ($this->option('no-migrate')) {
            $this->info('No migrate.');

            return;
        }

        $this->call('migrate:fresh', ['--force' => true, '--seed' => $this->option('seed')]);
    }
}
