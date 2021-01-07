<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Console;

use UcanLab\LaravelDacapo\Dacapo\UseCase\Console\DacapoInitCommandUseCase;

/**
 * Class DacapoInitCommand
 */
class DacapoInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:init
        {--laravel6 : Laravel 6.x default schema}
        {--laravel7 : Laravel 7.x default schema}
        {--laravel8 : Laravel 8.x default schema}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init dacapo default schema.';

    /**
     * @var DacapoInitCommandUseCase
     */
    protected DacapoInitCommandUseCase $useCase;

    /**
     * DacapoInitCommand constructor.
     * @param DacapoInitCommandUseCase $useCase
     */
    public function __construct(DacapoInitCommandUseCase $useCase)
    {
        parent::__construct();

        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        if ($this->option('laravel8')) {
            $this->useCase->handle('laravel8');
        } elseif ($this->option('laravel7')) {
            $this->useCase->handle('laravel7');
        } elseif ($this->option('laravel6')) {
            $this->useCase->handle('laravel6');
        } else {
            $this->useCase->handle('laravel8');
        }

        $this->info('Generated default.yml');
    }
}
