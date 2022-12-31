<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

/**
 * Class DacapoConfigPublishCommand
 */
final class DacapoConfigPublishCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:config:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish dacapo config that are available for customization.';

    public function handle(): void
    {
        $configPath = $this->laravel->configPath();

        $files = [
            (string) realpath(__DIR__ . '/DacapoConfigPublishCommand/dacapo.php') => $configPath . '/dacapo.php',
        ];

        foreach ($files as $from => $to) {
            if (! file_exists($to) || $this->option('force')) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        $this->components->info('Config published successfully.');
    }
}
