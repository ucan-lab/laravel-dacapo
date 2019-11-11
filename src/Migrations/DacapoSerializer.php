<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Storage\Storage;

/**
 * Class DacapoSerializer.
 */
class DacapoSerializer
{
    private $schemasStorage;
    private $migrationsStorage;
    private $connections;

    /**
     * DacapoSerializer constructor.
     *
     * @param Storage $schemasStorage
     * @param Storage $migrationsStorage
     * @param Connections $connections
     */
    public function __construct(Storage $schemasStorage, Storage $migrationsStorage, Connections $connections)
    {
        $this->schemasStorage = $schemasStorage;
        $this->migrationsStorage = $migrationsStorage;
        $this->connections = $connections;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        foreach ($this->connections as $connection) {
            (new DatabaseLoader($connection))->run();
        }
    }
}
