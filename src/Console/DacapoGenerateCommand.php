<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\Migrations\DacapoGenerator;
use UcanLab\LaravelDacapo\Storage\MigrationsMockStorage;
use UcanLab\LaravelDacapo\Storage\MigrationsStorage;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;

/**
 * Class DacapoGenerateCommand
 */
class DacapoGenerateCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:generate
        {--f|force : Force the operation to run when in production}
        {--fresh : Drop all tables and re-run all migrations}
        {--refresh : Reset and re-run all migrations}
        {--seed : Seed the database with records}
        {--dry-run : Outputs the operations but will not execute anything}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate migration files.';

    /**
     * @return void
     */
    public function handle(): void
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->call('dacapo:clear', ['--force' => true]);

        if ($this->option('dry-run')) {
            $migrationsStorage = new MigrationsMockStorage();
        } else {
            $migrationsStorage = new MigrationsStorage();
        }

        (new DacapoGenerator(new SchemasStorage(), $migrationsStorage))->run();
        $this->info('Generated migration files.');

        if ($this->option('dry-run')) {
            return;
        }

        if ($this->option('seed')) {
            $this->call('migrate:fresh', ['--force' => true, '--seed' => true]);
        } elseif ($this->option('fresh')) {
            $this->call('migrate:fresh', ['--force' => true]);
        } elseif ($this->option('refresh')) {
            $this->call('migrate:refresh', ['--force' => true]);
        }
    }
}
