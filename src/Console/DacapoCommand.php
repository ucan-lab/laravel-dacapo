<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;
use UcanLab\LaravelDacapo\Storage\MigrationsStorage;
use UcanLab\LaravelDacapo\Migrations\DacapoGenerator;

/**
 * Class DacapoCommand.
 */
class DacapoCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo
        {--no-migrate : Do not migrate}
        {--seed : Seed the database with records}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate migration file and migrate fresh.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->call('dacapo:clear', ['--force' => true]);
        $this->runDacapoGenerate();
        $this->info('Generated migration files.');

        if ($this->option('no-migrate')) {
            $this->info('No migrate.');
            return;
        }

        $this->runMigrate();
    }

    /**
     * @return void
     */
    protected function runDacapoGenerate(): void
    {
        (new DacapoGenerator(new SchemasStorage(), new MigrationsStorage()))->run();
    }

    /**
     * @return void
     */
    protected function runMigrate(): void
    {
        $this->call('migrate:fresh', ['--seed' => $this->option('seed')]);
    }
}
