<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Console;

use Carbon\Carbon;
use Illuminate\Console\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends BaseCommand
{
    protected CommandTimer $timer;

    /**
     * Command constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->timer = new CommandTimer(Carbon::now(), Carbon::now());
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->beforeHandle();
        $code = (int) $this->laravel->call([$this, 'handle']);
        $this->afterHandle();

        return $code;
    }

    protected function beforeHandle(): void
    {
        $this->timer->start();
        $message = sprintf('<fg=yellow>Starting:</> laravel artisan <fg=magenta>%s</> command', $this->name);
        $this->line($message);
    }

    protected function afterHandle(): void
    {
        $this->timer->stop();
        $message = sprintf('<fg=green>Finished:</> laravel artisan <fg=magenta>%s</> command, <fg=magenta>%s</> seconds, max memory: <fg=magenta>%s</> MB.', $this->name, $this->timer->getTotalSeconds(), $this->getMaxMemory());
        $this->line($message);
    }

    /**
     * @return float
     */
    private function getMaxMemory(): float
    {
        return memory_get_peak_usage(true) / (1024 * 1024);
    }
}
