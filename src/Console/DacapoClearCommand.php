<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\App\UseCase\Console\DacapoClearCommandUseCase;

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
     * @var DacapoClearCommandUseCase
     */
    protected DacapoClearCommandUseCase $useCase;

    /**
     * DacapoClearCommand constructor.
     * @param DacapoClearCommandUseCase $useCase
     */
    public function __construct(DacapoClearCommandUseCase $useCase)
    {
        parent::__construct();

        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        $deleteFiles = $this->useCase->handle();

        if (empty($deleteFiles)) {
            $this->info('No migration file generated by Dacapo.');
        } else {
            foreach ($deleteFiles as $file) {
                $this->info(sprintf('%s is deleted.', $file));
            }
        }
    }
}
