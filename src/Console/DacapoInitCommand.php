<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
        {--legacy : legacy default schema}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init dacapo default schema. Laravel 5.6 or lower.';

    /**
     * @return void
     */
    public function handle()
    {
        if ($this->existsSchemasDirectory()) {
            if ($this->ask('The database/schemas directory already exists. Initialize ? [y/N]')) {
                $this->deleteSchemasDirectory();
                $this->makeSchemasDirectory();
            } else {
                $this->comment('Command Cancelled!');
                return;
            }
        } else {
            $this->makeSchemasDirectory();
        }

        $this->initSchema();
    }

    /**
     * init dacapo default schema
     *
     * @return void
     */
    private function initSchema(): void
    {
        if ($this->option('legacy')) {
            File::copy($this->getStoragePath() . '/default.legacy.yml', database_path('schemas/default.yml'));
        } else {
            File::copy($this->getStoragePath() . '/default.yml', database_path('schemas/default.yml'));
        }

        $this->info('Init dacapo default schema yaml.');
    }

    /**
     * @return bool
     */
    private function existsSchemasDirectory(): bool
    {
        return File::exists($this->getSchemasPath());
    }

    /**
     * @return bool
     */
    private function makeSchemasDirectory(): bool
    {
        return File::makeDirectory($this->getSchemasPath());
    }

    /**
     * @return bool
     */
    private function deleteSchemasDirectory(): bool
    {
        return File::deleteDirectory($this->getSchemasPath());
    }

    /**
     * @return string
     */
    private function getSchemasPath(): string
    {
        return database_path('schemas');
    }

    /**
     * @return string
     */
    private function getStoragePath(): string
    {
        return __DIR__ . '/../Storage/schemas';
    }
}
