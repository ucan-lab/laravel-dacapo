<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Console;

use UcanLab\LaravelDacapo\Dacapo\UseCase\Console\DacapoUninstallCommandUseCase;

/**
 * Class DacapoUninstallCommand
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

    /**
     * @var DacapoUninstallCommandUseCase
     */
    protected DacapoUninstallCommandUseCase $useCase;

    /**
     * DacapoUninstallCommand constructor.
     * @param DacapoUninstallCommandUseCase $useCase
     */
    public function __construct(DacapoUninstallCommandUseCase $useCase)
    {
        parent::__construct();

        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        if ($this->useCase->handle()) {
            $this->info('Deleted schemas directory.');
            $this->info('Please delete dacapo composer package.');
            $this->comment('composer remove --dev ucan-lab/laravel-dacapo');
        } else {
            $this->error('Failed to delete the schemas directory.');
        }
    }
}
