<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;

/**
 * Class DacapoInitCommand.
 */
class DacapoInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:init
        {--laravel50 : Laravel 5.0 default schema}
        {--laravel57 : Laravel 5.7 default schema}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init dacapo default schema. Laravel 5.6 or lower.';

    private $schemasStorage;

    public function __construct()
    {
        parent::__construct();
        $this->schemasStorage = new SchemasStorage();
    }

    /**
     * @return void
     */
    public function handle()
    {
        if ($this->schemasStorage->exists()) {
            if ($this->ask('The database/schemas directory already exists. Initialize ? [y/N]')) {
                $this->schemasStorage->deleteDirectory();
                $this->schemasStorage->makeDirectory();
            } else {
                $this->comment('Command Cancelled!');

                return;
            }
        } else {
            $this->schemasStorage->makeDirectory();
        }

        $this->initSchema();
    }

    /**
     * init dacapo default schema.
     *
     * @return void
     */
    private function initSchema(): void
    {
        if ($this->option('laravel50')) {
            File::copy($this->getDefaultSchemasPath('laravel50_default.yml'), $this->schemasStorage->getPath('default.yml'));
        } elseif ($this->option('laravel57')) {
            File::copy($this->getDefaultSchemasPath('laravel57_default.yml'), $this->schemasStorage->getPath('default.yml'));
        } else {
            File::copy($this->getDefaultSchemasPath('laravel60_default.yml'), $this->schemasStorage->getPath('default.yml'));
        }

        $this->info('Init dacapo default schema yaml.');
    }

    /**
     * @param string $path
     * @return string
     */
    private function getDefaultSchemasPath(string $path): string
    {
        return __DIR__ . '/../Storage/schemas/' . $path;
    }
}
