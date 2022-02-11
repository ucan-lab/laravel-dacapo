<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class DacapoStubPublishCommand
 */
final class DacapoStubPublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:stub:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish dacapo stubs that are available for customization.';

    /**
     * @param Filesystem $filesystem
     */
    public function handle(Filesystem $filesystem): void
    {
        if (! is_dir($stubsPath = $this->laravel->basePath('stubs'))) {
            $filesystem->makeDirectory($stubsPath);
        }

        $files = [
            (string) realpath(__DIR__ . '/../Dacapo/Infra/Adapter/Stub/dacapo.migration.create.stub') => $stubsPath . '/dacapo.migration.create.stub',
            (string) realpath(__DIR__ . '/../Dacapo/Infra/Adapter/Stub/dacapo.migration.update.stub') => $stubsPath . '/dacapo.migration.update.stub',
        ];

        foreach ($files as $from => $to) {
            if (! file_exists($to) || $this->option('force')) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        $this->info('Stubs published successfully.');
    }
}
