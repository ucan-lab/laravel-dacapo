<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use UcanLab\LaravelDacapo\Migrations\Connections;
use UcanLab\LaravelDacapo\Migrations\DacapoSerializer;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;
use UcanLab\LaravelDacapo\Storage\MigrationsStorage;

/**
 * Class DacapoSerializeCommand.
 */
class DacapoSerializeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:serialize {--c|connections= : Comma-separated target connections.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serialize existing database into dacapo files.';

    /**
     * @param Connections $connections
     * @return void
     */
    public function handle(Connections $connections): void
    {
        $names = collect(explode(',', $this->option('connections')))
            ->map->trim()
            ->map->filter()
            ->values()
            ->all() ?: [null];

        foreach ($names as $name) {
            $connections->add($name);
        }

        (new DacapoSerializer(new SchemasStorage(), new MigrationsStorage(), $connections))->run();

        $this->info('Serialized existing database.');
    }
}
