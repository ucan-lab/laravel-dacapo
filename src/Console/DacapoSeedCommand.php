<?php

namespace UcanLab\LaravelDacapo\Console;

/**
 * Class DacapoSeedCommand.
 */
class DacapoSeedCommand extends DacapoCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate migration file and migrate fresh and db seed.';

    /**
     * @return void
     */
    protected function runMigrate(): void
    {
        $this->call('migrate:fresh', ['--seed' => true]);
    }
}
