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
        $this->initSchema();
    }

    /**
     * init dacapo default schema
     *
     * @return void
     */
    private function initSchema()
    {
        File::makeDirectory(database_path('schemas'));

        if ($this->option('legacy')) {
            File::copy(__DIR__ . '/../Storage/schemas/default.legacy.yml', database_path('schemas/default.yml'));
        } else {
            File::copy(__DIR__ . '/../Storage/schemas/default.yml', database_path('schemas/default.yml'));
        }

        $this->info('Init dacapo default schema yaml.');
    }
}
