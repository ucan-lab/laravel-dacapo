<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\Migrations\SchemaLoader;
use UcanLab\LaravelDacapo\Generator\ModelTemplateGenerator;
use UcanLab\LaravelDacapo\Storage\ModelsStorage;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;

/**
 * Class DacapoModelsCommand
 */
class DacapoModelsCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate template models.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->generateTemplateModels();
    }

    /**
     * clear migrations directory
     *
     * @return void
     */
    private function generateTemplateModels(): void
    {
        $tables = (new SchemaLoader(new SchemasStorage()))->run();
        $modelStorage = new ModelsStorage();

        (new ModelTemplateGenerator($tables, $modelStorage))->run();
        $this->info('Cleared migration directory.');
    }
}
